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
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password1' => 'required|string',
        ]);

        $user = User::create([
            //'username' => $request->username,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password1),
            //'country_idcountry' => $request->country_idcountry,
            //'department_iddepartment' => $request->department_iddepartment,
            //'role_idrole' => $request->role_idrole,
        ]);

        $sessionData = [
           'user_id' => $user->id, // Ukladáme 'id' používateľa do session ako 'user_id'
           'user_name' => $user->name, // Ukladáme meno používateľa
        ];

    
        return response()->json([
            'message' => 'Registrácia úspešná',
            'token_type' => 'Bearer',
            'session' => $sessionData, // Include session in the response
        ]);
    }
}
