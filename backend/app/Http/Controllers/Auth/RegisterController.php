<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
            'country' => 'required|exists:country,idcountry', // Validate foreign key
            'university' => 'required|exists:university,iduniversity', // Validate foreign key
            'faculty' => 'required|exists:faculty,idfaculty',         // Validate foreign key
            'department' => 'required|exists:department,iddepartment', // Validate foreign key
            'email' => 'required|email|unique:user,email',             // Correct the table name
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),                // Correct the password field
            'country_idcountry' => $request->country,          // Save the foreign key
            'department_iddepartment' => $request->department,           // Save the department
            'created_on' => now(),// Add the created_on column
            'updated_on' => now(), // Add the created_on column
            'role_idrole' => $request->role_idrole ?? 1,                 // Default role (e.g., student)
        ]);

        $user->degrees()->attach($request->degrees);

        $sessionData = [
           'user_id' => $user->iduser, // Ukladáme 'id' používateľa do session ako 'user_id'
           'user_role' => $user->role_idrole,
           'user_name' => $user->name, // Ukladáme meno používateľa
        ];

        $token = $user->createToken('auth_token')->plainTextToken; // create token mi hádže v IDE chybu, ale nakoľko robím vo VS Code s random intellisense z marketplacu, to môže byť chyba toho.
        // fixnuté s @var...
        return response()->json([
            'message' => 'Prihlásenie úspešné',
            'access_token' => $token,
            'session' => $sessionData,
            'token_type' => 'Bearer',
        ]);
    }

}
