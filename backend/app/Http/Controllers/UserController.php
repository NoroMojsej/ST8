<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUserInfo($userId)
    {
        try {
            // Načítanie používateľa s country, department, faculty a university
            $user = User::with([
                'country',
                'department.faculty.university'
            ])->findOrFail($userId);

            $userData = $user->toArray();
            $userData['country'] = $user->country ? $user->country : null;
            $userData['department'] = $user->department ? $user->department : null;
            $userData['faculty'] = $user->department && $user->department->faculty
                ? $user->department->faculty
                : null;
            $userData['university'] = $user->department && $user->department->faculty && $user->department->faculty->university
                ? $user->department->faculty->university
                : null;

            return response()->json($userData);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Používateľ neexistuje'], 404);
        }
    }

    public function update(Request $request, int $iduser)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $iduser . ',iduser', // povoliť súčastný mail užívateľa
            'country' => 'required|exists:country,idcountry',
            'department' => 'required|exists:department,iddepartment',
        ]);

        $user = User::findOrFail($iduser);
        $user->update([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'country_idcountry' => $data['country'],
            'department_iddepartment' => $data['department'],
        ]);

        $user->load(['department.faculty.university']);

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => [
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'country' => $user->country_idcountry,
                'department' => $user->department->iddepartment ?? null,
                'faculty' => $user->department->faculty->idfaculty ?? null,
                'university' => $user->department->faculty->university->iduniversity ?? null,
            ],
        ]);
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'orgPswd' => 'required',
            'newPswd' => 'required|string|min:8',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->input('orgPswd'), $user->password_hash)) {
            return response()->json(['message' => 'Original password is incorrect.'], 403);
        }

        $user->password_hash = Hash::make($request->input('newPswd'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function getUsersList()
{
    $users = User::join('department', 'user.department_iddepartment', '=', 'department.iddepartment')
                 ->join('faculty', 'department.faculty_idfaculty', '=', 'faculty.idfaculty')
                 ->join('university', 'faculty.university_iduniversity', '=', 'university.iduniversity')
                 ->join('role', 'user.role_idrole', '=', 'role.idrole')
                 ->whereIn('user.role_idrole', [1, 3])
                 ->select(
                     'user.name',
                     'user.surname',
                     'university.code as university_code',
                     'role.code as role_code'
                 )
                 ->get();

    return response()->json($users);
}

public function changeRole(Request $request, $userId)
{
    $validated = $request->validate([
        'role_code' => 'required|string|exists:role,code',
    ]);

    try {
        $roleId = Role::where('code', $validated['role_code'])->value('idrole');

        if (!$roleId) {
            return response()->json(['status' => 'error', 'message' => 'Invalid role code.'], 400);
        }

        $user = User::findOrFail($userId);
        $user->role_idrole = $roleId;
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Role updated successfully.'], 200);

    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}

}
