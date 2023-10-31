<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        try {
            $usuarios = User::all();

            if ($usuarios == null) {
                return response()->json([
                    "message" => "Usuários não encontrados.",
                    "success" => true
                ], 400);
            }

            return response()->json([
                "usuarios" => $usuarios,
                "message" => "Usuários encontrados.",
                "success" => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Usuários não encontrados.",
                "success" => true
            ], 400);
        }

    }

    public function show($registro)
    {
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
        try {
            $this->validate($request, [
                'registro' => 'required|numeric|unique:users',
                'email' => 'required|unique:users|email',
                'nome' => 'required',
                'senha' => 'required',
            ]);

            $user = new User;
            $user->registro = $request->registro;
            $user->email = $request->email;
            $user->nome = $request->nome;
            $user->senha = $request->senha;

            if (isset($request->tipo_usuario)) {
                $user->tipo_usuario = $request->tipo_usuario;
            }

            $user->save();

            return response()->json([
                "message" => "Usuário criado com sucesso.",
                "success" => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }
    }

    public function update(Request $request, $registro)
    {
        try {

            $user = User::findOrFail($registro);


            $this->validate($request, [
                "email" => "unique:users,email,{$user->registro},registro",
            ]);


            $user->email = $request->email;
            $user->nome = $request->nome;
            $user->senha = $request->senha;

            if (isset($request->tipo_usuario)) {
                $user->type_user = $request->tipo_usuario;
            }

            $user->save();

            return response()->json([
                "message" => "Usuário atualizado com sucesso.",
                "success" => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }
    }

    public function destroy(Request $request, $registro)
    {
        try {

            $user = User::findOrFail($registro);

            $user->delete();

            return response()->json([
                "message" => "Usuário removido com sucesso.",
                "success" => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }
    }

}