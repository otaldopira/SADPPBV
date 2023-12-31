<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PointController extends Controller
{

    public function index()
    {
        Log::channel('retorno')->info('OP - Listar Pontos | Recebido: ');
        try {
            $pontos = Point::all();

            if ($pontos == null) {
                return response()->json([
                    "message" => "Pontos não encontrado.",
                    "success" => false
                ], 400);
            }
            $retorno = [];

            return response()->json([
                "pontos" => $pontos,
                "message" => "Pontos retornados com sucesso.",
                "success" => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }

    }

    public function store(Request $request)
    {
        Log::channel('retorno')->info('OP - Cadastrar Ponto | Recebido: ' . json_encode($request->all()));
        try {
            $ponto = new Point;
            $ponto->nome = $request->nome;
            $ponto->save();

            return response()->json([
                "message" => "Ponto criado com sucesso.",
                "success" => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }
    }

    public function show($id)
    {
        Log::channel('retorno')->info('OP - Listar Ponto | Recebido: ID:' . $id);
        try {
            $ponto = Point::find($id);

            if ($ponto == null) {
                return response()->json([
                    "message" => "Ponto não encontrado.",
                    "success" => false
                ], 400);
            }

            return response()->json([
                "ponto" => $ponto,
                "message" => "Ponto retornado com sucesso.",
                "success" => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }

    }

    public function update(Request $request, $id)
    {
        Log::channel('retorno')->info('OP - Atualizar Ponto | Recebido: ID: ' . $id . json_encode($request->all()));
        try {

            $ponto = Point::find($id);

            if ($ponto == null) {
                return response()->json([
                    "message" => "Ponto não encontrado.",
                    "success" => false
                ], 400);
            }

            $ponto->nome = $request->nome;
            $ponto->save();

            return response()->json([
                "message" => "Ponto atualizado com sucesso.",
                "success" => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }
    }

    public function destroy($id)
    {
        Log::channel('retorno')->info('OP - Remover Ponto | Recebido: ID: ' . $id);
        try {

            $ponto = Point::findOrFail($id);

            $ponto->delete();

            return response()->json([
                "message" => "Ponto removido com sucesso.",
                "success" => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Este ponto está sendo usado por algum segmento.",
                "success" => false
            ], 400);
        }
    }
}
