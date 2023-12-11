<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;

class DijkstraController extends Controller
{
    public function calcularRota(Request $request)
    {
        try {
            Log::channel('retorno')->info('OP - Calcular Rota | Recebido:' . json_encode($request->all()));
            $origem = strtolower(trim($request->origem));
            $destino = strtolower(trim($request->destino));

            $origem_id = DB::table('points')
                ->whereRaw("LOWER(TRIM(nome)) = ?", [$origem])
                ->value('ponto_id');

            $destino_id = DB::table('points')
                ->whereRaw("LOWER(TRIM(nome)) = ?", [$destino])
                ->value('ponto_id');


            if (!$origem_id || !$destino_id) {
                return response()->json([
                    "message" => "Os pontos de origem e/ou destino não foram encontrados",
                    "success" => false
                ], 404);
            }

            // Obtém todos os pontos do banco de dados.
            $pontos = DB::table('points')->get();

            // Cria um array associativo para mapear IDs de locais para nomes.
            $pontosMap = [];
            foreach ($pontos as $ponto) {
                $pontosMap[$ponto->ponto_id] = $ponto->nome;
            }

            // Obtém os segmentos do banco de dados.
            $segments = DB::table('segments')->where('status', 1)->get();

            // Inicializa o conjunto de nós visitados.
            $visitado = [];

            // Inicializa as distâncias mínimas para todos os locais com infinito, exceto para o local de origem.
            $distancias = [];
            foreach ($pontos as $ponto) {
                $distancias[$ponto->ponto_id] = INF;
            }
            $distancias[$origem_id] = 0;

            while (count($visitado) < count($pontos)) {
                // Encontra o nó não visitado mais próximo.
                $minDistance = INF;
                $minLocation = null;

                foreach ($pontos as $ponto) {

                    if (!in_array($ponto->ponto_id, $visitado) && $distancias[$ponto->ponto_id] < $minDistance) {
                        $minDistance = $distancias[$ponto->ponto_id];
                        $minLocation = $ponto->ponto_id;
                    }
                }
                // Marca o nó atual como visitado.
                $visitado[] = $minLocation;
                // Atualiza as distâncias mínimas para os vizinhos não visitados do nó atual.
                foreach ($segments as $segment) {
                    if ($segment->ponto_inicial == $minLocation && !in_array($segment->ponto_final, $visitado)) {
                        $newDistance = $distancias[$minLocation] + $segment->distancia;
                        if ($newDistance < $distancias[$segment->ponto_final]) {
                            $distancias[$segment->ponto_final] = $newDistance;
                        }
                    }
                }
            }

            // Constrói o caminho a partir das distâncias mínimas calculadas.
            $caminho = [];
            $destinoAtual = $destino_id;
            while ($destinoAtual != $origem_id) {
                $segmentoEncontrado = null;
                foreach ($segments as $segment) {
                    if ($segment->ponto_final == $destinoAtual && $distancias[$segment->ponto_inicial] + $segment->distancia == $distancias[$destinoAtual]) {

                        $destinoAtual = $segment->ponto_inicial;

                        // Encontra o segmento pelo ID do segmento
                        $segmentoCompleto = $this->encontrarSegmentoPorID($segments, $segment->segmento_id, $pontos);

                        if ($segmentoCompleto) {

                            $segmentoEncontrado = $segmentoCompleto;
                        }
                        break;
                    }
                }
                if (!$segmentoEncontrado) {
                    // Não há rota disponível, retorna uma resposta de erro.
                    return response()->json([
                        "message" => "Não há rota disponível entre os pontos de origem e destino.",
                        "success" => false
                    ], 404);
                }

                $caminho[] = $segmentoEncontrado;
            }


            // Inverte o caminho para que ele vá do ponto de partida ao ponto de destino.
            $caminho = array_reverse($caminho);

            // Verifica se o caminho está vazio, o que indica que não há rota disponível.
            if (empty($caminho)) {
                return response()->json([
                    "message" => "Não há rota disponível entre os pontos de origem e destino.",
                    "success" => false
                ], 404);
            }

            // Inverte o caminho para que ele vá do ponto de partida ao ponto de destino.
            $rota = new stdClass();
            $rota->origem = $pontosMap[$origem_id];
            $rota->destino = $pontosMap[$destino_id];
            $rota->distancia = $distancias[$destino_id];
            $rota->caminho = $caminho;

            $chegada = end($caminho);

            $chegada->direcao = $chegada->ponto_final . ' -> Chegada';

            // Constrói um objeto com informações sobre a rota.
            return response()->json([
                "rota" => $caminho,
                "message" => "Rota retornada com sucesso.",
                "success" => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 400);
        }



    }

    private function encontrarSegmentoPorID($segments, $segmentoId, $pontos)
    {
        foreach ($segments as $segment) {
            if ($segment->segmento_id == $segmentoId) {
                $pontoInicial = $this->findPointById($pontos, $segment->ponto_inicial);
                $pontoFinal = $this->findPointById($pontos, $segment->ponto_final);

                $segment->ponto_inicial = $pontoInicial;
                $segment->ponto_final = $pontoFinal;

                return $segment;
            }
        }
        return null;
    }

    private function findPointById($pontos, $pontoId)
    {
        foreach ($pontos as $ponto) {
            if ($pontoId == $ponto->ponto_id ) {
                return $ponto->nome;
            }
        }
    }


}
