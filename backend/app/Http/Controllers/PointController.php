<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{

    public function index()
    {
        return response()->json([
            "pontos" => Point::all(),
            "message" => "Pontos retornados com sucesso.",
            "success" => true
        ], 200);
    }

    public function store(Request $request)
    {
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
        return response()->json([
            "pontos" => Point::findOrFail($id),
            "message" => "Ponto retornado com sucesso.",
            "success" => true
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {

            $ponto = Point::findOrFail($id);
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
        try {

            $ponto = Point::findOrFail($id);

            $ponto->delete();

            return response()->json([
                "message" => "Ponto removido com sucesso.",
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
