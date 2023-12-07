<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        Log::channel('retorno')->info('OP - Index Usuário | Recebido:');
        try {
            $usuarios = User::all();
            $retorno = null;

            if ($usuarios == null) {
                $retorno = [
                    "message" => "Usuários não encontrados.",
                    "success" => false
                ];
                return response()->json($retorno, 400);
            }

            $retorno = [
                "usuarios" => $usuarios,
                "message" => "Usuários encontrados.",
                "success" => true
            ];
            Log::channel('retorno')->info('OP - Index Usuário | Enviado:' . json_encode($retorno));
            return response()->json($retorno, 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Usuários não encontrados.",
                "success" => true
            ], 400);
        }

    }

    public function show($registro)
    {
        Log::channel('retorno')->info('OP - Listar Usuário | Recebido:' . $registro);
        try {


            $usuario = User::find($registro);
            if ($usuario == null) {
                return response()->json([
                    "message" => "Usuário não encontrado.",
                    "success" => true
                ], 400);
            }

            return response()->json([
                "usuario" => $usuario,
                "message" => "Usuário encontrado.",
                "success" => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Usuário não encontrado.",
                "success" => true
            ], 400);
        }

    }


    public function store(Request $request)
    {
        Log::channel('retorno')->info('OP - Cadastrar Usuário | Recebido:' . json_encode($request->all()));
        try {
            $retorno = null;
            $validator = Validator::make($request->all(), [
                'registro' => 'required|numeric|unique:users',
                'email' => 'required|unique:users|email',
                'nome' => 'required',
                'senha' => 'required',
            ]);

            if ($validator->fails()) {
                $retorno = [
                    "message" => $validator->errors()->first(),
                    "success" => false
                ];
                Log::channel('retorno')->info('OP - Cadastrar Usuário | Enviado:' . json_encode($retorno));
                return response()->json($retorno, 400);
            }

            if($request->senha == "d41d8cd98f00b204e9800998ecf8427e"){
                $retorno = [
                    "message" => "Não é possível cadastrar senha em branco.",
                    "success" => false
                ];
                Log::channel('retorno')->info('OP - Cadastrar Usuário | Enviado:' . json_encode($retorno));
                return response()->json($retorno, 400);
            }

            $user = new User;
            $user->registro = $request->registro;
            $user->email = $request->email;
            $user->nome = $request->nome;
            $user->senha = $request->senha;

            if (isset($request->tipo_usuario) ) {
                $user->tipo_usuario = $request->tipo_usuario;
            }

            $user->save();
            $retorno = [
                "message" => "Usuário criado com sucesso.",
                "success" => true
            ];
            Log::channel('retorno')->info('OP - Cadastrar Usuário | Enviado:' . json_encode($retorno));
            return response()->json($retorno, 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }
    }

    public function update(Request $request, $registro)
    {
        Log::channel('retorno')->info('OP - Update Usuário | Recebido:' . ' Registro: ' . $registro . json_encode($request->all()));

        try {
            $user = User::find($registro);
            $retorno = null;
            if ($user == null) {
                $retorno = [
                    "message" => "Usuário não encontrado.",
                    "success" => true
                ];
                Log::channel('retorno')->info('OP - Update Usuário | Enviado:' . $registro . json_encode($retorno));
                return response()->json($retorno, 400);
            }

            if ($user->email != $request->email) {
                $validator = Validator::make($request->all(), [
                    'email' => 'unique:users'
                ]);

                if ($validator->fails()) {
                    $retorno = [
                        "message" => $validator->errors()->first(),
                        "success" => false
                    ];
                    Log::channel('retorno')->info('OP - Update Usuário | Enviado:' . $registro . json_encode($retorno));
                    return response()->json($retorno, 400);
                }
            }

            if($request->senha == "d41d8cd98f00b204e9800998ecf8427e"){
                $retorno = [
                    "message" => "Não é possível cadastrar senha em branco.",
                    "success" => false
                ];
                Log::channel('retorno')->info('OP - Update Usuário | Enviado:' . $registro . json_encode($retorno));
                return response()->json($retorno, 400);
            }

            $user->email = $request->email;
            $user->nome = $request->nome;
            $user->senha = $request->senha;

            if (isset($request->tipo_usuario) && $user->tipo_usuario == 1) {
                $user->tipo_usuario = $request->tipo_usuario;
            } else if ($request->tipo_usuario == 1 && $user->tipo_usuario == 0){
                $retorno = [
                    "message" => "Você não tem permissão para alterar o tipo de usuário.",
                    "success" => false
                ];
                Log::channel('retorno')->info('OP - Update Usuário | Enviado:' . $registro . json_encode($retorno));
                return response()->json($retorno, 401);
            }

            if ($user->save()) {
                $retorno = [
                    "message" => "Usuário atualizado com sucesso.",
                    "success" => true
                ];
                Log::channel('retorno')->info('OP - Update Usuário | Enviado:' . $registro . json_encode($retorno));
                return response()->json($retorno, 200);
            }
        } catch (\Exception $e) {
            $retorno = [
                "message" => $e->getMessage(),
                "success" => false
            ];
            Log::channel('retorno')->info('OP - Update Usuário | Enviado:' . $registro . json_encode($retorno));
            return response()->json($retorno, 400);
        }
    }

    public function destroy(Request $request, $registro)
    {
        Log::channel('retorno')->info('OP - Remover Usuário | Recebido: Registro:' . $registro . json_encode($request->all()));
        try {

            $retorno = null;

            $user = User::find($registro);

            $count = DB::table('users')->count();

            if($count == 1){
                $retorno =[
                    "message" => "Não é possível remover o último usuário do sistema.",
                    "success" => false
                ];
                Log::channel('retorno')->info('OP - Remover Usuário | Enviado:' . json_encode($retorno));
                return response()->json($retorno, 400);
            }

            if ($user == null) {
                $retorno =[
                    "message" => "Não foi possível encontrar o usuário.",
                    "success" => false
                ];
                Log::channel('retorno')->info('OP - Remover Usuário | Enviado:' . json_encode($retorno));
                return response()->json($retorno, 400);
            }

            $user->tokens->each->delete();

            $user->delete();

            $retorno =[
                "message" => "Usuário removido com sucesso.",
                "success" => true
            ];

            Log::channel('retorno')->info('OP - Remover Usuário | Enviado:' . json_encode($retorno));
            return response()->json($retorno, 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }
    }

}
