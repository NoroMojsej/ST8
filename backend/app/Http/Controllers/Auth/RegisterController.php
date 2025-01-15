<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'degrees' => 'required|array|min:1|exists:degree,iddegree',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'country' => 'required|exists:country,idcountry',
            'university' => 'required|exists:university,iduniversity',
            'faculty' => 'required|exists:faculty,idfaculty',
            'department' => 'required|exists:department,iddepartment',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'country_idcountry' => $request->country,
            'department_iddepartment' => $request->department,
            'created_on' => now(),
            'updated_on' => now(),
            'role_idrole' => $request->role_idrole ?? Role::where('code', 'STDNT')->value('idrole'),
        ]);

        $user->degrees()->attach($request->degrees);

        $sessionData = [
            'user_id' => $user->iduser,
            'user_role' => $user->role_idrole,
            'user_first_name' => $user->name,
            'user_last_name' => $user->surname,
         ];

        $token = $user->createToken('auth_token')->plainTextToken;
        // fixnuté s @var...
        return response()->json([
            'message' => 'Prihlásenie úspešné',
            'access_token' => $token,
            'session' => $sessionData,
            'token_type' => 'Bearer',
        ]);
    }

}
