<?php

namespace App\Http\Controllers;

use App\Models\Segment;
use Illuminate\Http\Request;

class SegmentController extends Controller
{
    public function index()
    {
        return response()->json([
            "segmentos" => Segment::all(),
            "message" => "Segmentos retornados com sucesso.",
            "success" => true
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $segmento = new Segment;
            $segmento->ponto_inicial = $request->ponto_inicial;
            $segmento->ponto_final = $request->ponto_final;
            $segmento->distancia = $request->distancia;
            $segmento->direcao = $request->direcao;
            $segmento->status = $request->status;
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
        return response()->json([
            "segmento" => Segment::findOrFail($id),
            "message" => "Segmento retornado com sucesso.",
            "success" => true
        ], 200);
    }

    public function update(Request $request, Segment $segment)
    {
        try {
            $segmento = Segment::findOrFail($segment);
            $segmento->ponto_inicial = $request->ponto_inicial;
            $segmento->ponto_final = $request->ponto_final;
            $segmento->distancia = $request->distancia;
            $segmento->direcao = $request->direcao;
            $segmento->status = $request->status;
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

    public function destroy(Segment $segment)
    {
        try {
            $segmento = Segment::findOrFail($segment);
            $segmento->destroy();

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