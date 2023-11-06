<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DijkstraController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/usuarios/{registro}', [UserController::class, 'update']);
    Route::delete('/usuarios/{registro}', [UserController::class, 'destroy']);

    Route::middleware(['VerificarNivelUsuario'])->group(function () {
        // USUÁRIOS
        Route::post('/usuarios', [UserController::class, 'store']);
        Route::get('/usuarios', [UserController::class, 'index']);
        Route::get('/usuarios/{registro}', [UserController::class, 'show']);
    });

});

// Antes de cadastrar o ADMINISTRATOR
// Route::post('/usuarios', [UserController::class, 'store']);




Route::get('/pontos', [PointController::class, 'index']);
Route::get('/pontos/{id}', [PointController::class, 'show']);
Route::put('/pontos/{id}', [PointController::class, 'update']);
Route::delete('/pontos/{id}', [PointController::class, 'destroy']);
Route::post('/pontos', [PointController::class, 'store']);

Route::post('/segmentos', [SegmentController::class, 'store']);
Route::get('/segmentos', [SegmentController::class, 'index']);
Route::get('/segmentos/{id}', [SegmentController::class, 'show']);

Route::post('/rotas', [DijkstraController::class, 'calcularRota']);