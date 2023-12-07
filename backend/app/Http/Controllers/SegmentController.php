<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SegmentController extends Controller
{
    public function index()
    {
        Log::channel('retorno')->info('OP - Listar Segmentos | Recebido: ');
        $segmentos = Segment::all();
        $retorno = [];

        foreach ($segmentos as $segmento) {
            $ponto_inicial = Point::find($segmento->ponto_inicial);
            $ponto_final = Point::find($segmento->ponto_final);
            $retorno[] = [
                "segmento_id" => $segmento['segmento_id'],
                "ponto_inicial" => $ponto_inicial['nome'],
                "ponto_final" => $ponto_final['nome'],
                "status" => $segmento['status'],
                "distancia" => $segmento['distancia'],
                "direcao" => $segmento['direcao']
            ];
        }

        return response()->json([
            "segmentos" => $retorno,
            "message" => "Segmentos retornados com sucesso.",
            "success" => true
        ], 200);
    }


    public function store(Request $request)
    {
        Log::channel('retorno')->info('OP - Cadastrar Segmento | Recebido: ' . json_encode($request->all()));
        try {
            $segmento = new Segment;
            $segmento->ponto_inicial = intval($request->ponto_inicial);
            $segmento->ponto_final = intval($request->ponto_final);
            $segmento->distancia = str_replace(',', '.', $request->distancia);
            $segmento->direcao = $request->direcao;
            $segmento->status = intval($request->status);
            $segmento->save();

            return response()->json([
                "message" => "Segmento criado com sucesso.",
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
        Log::channel('retorno')->info('OP - Listar Segmento | Recebido: ID:' . $id);
        try {
            $segmento = Segment::find($id);
            $retorno = null;

            $ponto_inicial = Point::find($segmento->ponto_inicial);
            $ponto_final = Point::find($segmento->ponto_final);
            $retorno = [
                "segmento_id" => $segmento['segmento_id'],
                "ponto_inicial" => $ponto_inicial['nome'],
                "ponto_final" => $ponto_final['nome'],
                "status" => $segmento['status'],
                "distancia" => $segmento['distancia'],
                "direcao" => $segmento['direcao']
            ];

            return response()->json([
                "segmento" => $retorno,
                "message" => "Segmento retornado com sucesso.",
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
        Log::channel('retorno')->info('OP - Atualizar Segmento | Recebido: ID:' . $id . json_encode($request->all()));
        try {
            $segmento = Segment::findOrFail($id);
            $segmento->ponto_inicial = intval($request->ponto_inicial);
            $segmento->ponto_final = intval($request->ponto_final);
            $segmento->distancia = str_replace(',', '.', $request->distancia);
            $segmento->direcao = $request->direcao;
            $segmento->status = intval($request->status);
            $segmento->save();

            return response()->json([
                "message" => "Segmento atualizado com sucesso.",
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
        Log::channel('retorno')->info('OP - Remover Segmento | Recebido: ID:' . $id);
        try {
            $segmento = Segment::findOrFail($id);
            $segmento->delete();

            return response()->json([
                "message" => "Segmento removido com sucesso.",
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
