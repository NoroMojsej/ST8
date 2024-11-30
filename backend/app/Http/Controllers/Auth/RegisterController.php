<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8|confirmed',
            'country_idcountry' => 'required|integer',
            'department_iddepartment' => 'required|integer',
            'role_idrole' => 'required|integer',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_idcountry' => $request->country_idcountry,
            'department_iddepartment' => $request->department_iddepartment,
            'role_idrole' => $request->role_idrole,
            'created_on' => now(),
            'updated_on' => now(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrácia úspešná',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
