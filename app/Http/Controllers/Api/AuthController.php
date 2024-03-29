<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register (RegisterAuth $request) {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'surname' => $request->surname,
            'dni' => $request->dni,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => $request->password
        ]);

        return response($user, Response::HTTP_CREATED);
        
    }

    public function login (Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token"=>$token], Response::HTTP_OK)->withoutCookie($cookie);
        } else {
            return response(["message" => "Usuario o contraseña inválido "],Response::HTTP_UNAUTHORIZED);
        }
    }

    public function userProfile (Request $request) {
        //requiere handle en middleware Authenticate
        return response()->json([
            'userData' => auth()->user()
        ], Response::HTTP_OK);
    }

    public function logout () {
        $user = auth()->user();
        $user->tokens()->delete();
        $user->currentAccessToken()->delete();
        $cookie = Cookie::forget('cookie_token');
        return response(["message" => "Cierre de session ok"], Response::HTTP_OK)->withCookie($cookie);
    }

}
