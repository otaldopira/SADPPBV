<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        Log::channel('retorno')->info('OP - Login | Recebido:' . json_encode($request->all()));
        try {
            if (Auth::attempt(['registro' => $request->registro, 'password' => $request->senha])) {
                $user = Auth::user();
                $token = $user->CreateToken('JWT')->plainTextToken;
                $tokenParts = explode('|', $token);
                $retorno = [
                    "registro" => $user->registro,
                    "token" => $tokenParts[1],
                    "success" => true,
                    "message" =>"Usuário logado com sucesso."
                ];

                Log::channel('retorno')->info('OP - Login | Enviado:' . json_encode($retorno));
                return response()->json($retorno, 200);
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
        Log::channel('retorno')->info('OP - Logout | Recebido:' . json_encode($request->all()));
        try {
            $request->user()->currentAccessToken()->delete();

            $retorno = [
                "success" => true,
                "message" => "Logout efetuado.",
            ];

            Log::channel('retorno')->info('OP - Logout | Enviado:' . json_encode($retorno));

            return response()->json($retorno, 200);

        }catch (\Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ],400);
        }
    }

    public function usuariosConectados()
    {
        $usuariosConectados = DB::table('personal_access_tokens')
            ->join('users', 'personal_access_tokens.tokenable_id', '=', 'users.registro')
            ->select('users.registro','users.nome', 'personal_access_tokens.created_at')
            ->get();

        return response()->json($usuariosConectados);
    }
}
