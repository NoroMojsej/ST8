<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email', // required
            'password' => 'required|min:8', // min char. dlzka 8, required
        ]);

        $userExists = User::where('email', $request->email)->exists();

        if (!$userExists) {
            return response()->json(['message' => 'Použivateľ neexistuje'], 404);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Nesprávne údaje'], 401);
        }

        // vytvorenie tokenu
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $sessionData = [
            'user_id' => $user->iduser, // Ukladáme 'id' používateľa do session ako 'user_id'
            'user_role' => $user->role_idrole,
            'user_first_name' => $user->name, // Ukladáme meno používateľa
            'user_last_name' => $user->surname,
         ];

        $token = $user->createToken('auth_token')->plainTextToken; // create token mi hádže v IDE chybu, ale nakoľko robím vo VS Code s random intellisense z marketplacu, to môže byť chyba toho.
        // fixnuté s @var...
        return response()->json([
            'message' => 'Prihlásenie úspešné',
            'session' => $sessionData,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Odhlásenie úspešné']);
    }

    public function user(Request $request)
    {
        // vráti nám usera z tabulky v JSON formáte.
        // príklad: 
        /*
            "id": 1,
            "name": "Joe Mama",
            "email": "joemama@gmail.com"
        */
        return response()->json($request->user());
    }
}