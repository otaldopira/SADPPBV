<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (Auth::attempt(['registro' => $request->registro, 'password' => $request->senha])) {
                $user = Auth::user();
                $token = $user->CreateToken('JWT')->plainTextToken;
                $tokenParts = explode('|', $token);
                return response()->json([
                    "token" => $tokenParts[1],
                    "success" => true,
                    "message" =>"Usuário logado com sucesso."
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Usuário não autorizado",
                ],401);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ],400);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Logout efetuado.",
        ]);


    }
}