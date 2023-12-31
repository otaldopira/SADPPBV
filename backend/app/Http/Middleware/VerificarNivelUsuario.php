<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerificarNivelUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // if (!Auth::check()) {
        //     return response()->json(['message' => 'Não autenticado.', 'success' => false], 401);
        // }

        // $user = Auth::user();

        // if ($user->tipo_usuario == 1) {
        //     return $next($request);
        // } else {
        //     return response()->json(['message' => 'Acesso não autorizado.', 'success' => false], 403);
        // }


        if (!Auth::check()) {
            return response()->json(['message' => 'Não autenticado.', 'success' => false], 401);
        }

        $user = Auth::user();
        $requestedUserId = $request->route('registro'); // Supondo que o parâmetro 'id' esteja na sua rota

        // Verifique se o usuário está tentando alterar seus próprios dados ou se é um administrador
        if ($user->registro == $requestedUserId || $user->tipo_usuario == 1) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Acesso não autorizado.', 'success' => false], 403);
        }
    }

}