<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    // Route::post('create', [AuthController::class, '']);
});

// Rutas relacionadas con la autenticación
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::post('restablecer-password', [AuthController::class, 'updatePassword']);

// Ruta para almacenar usuario
Route::middleware('auth:sanctum')->post('usuarios/store', [UserController::class, 'store']);
// Ruta para mostrar usuario
Route::middleware('auth:sanctum')->get('usuarios/{id}', [UserController::class, 'show']);
// Ruta para actualizar usuario
Route::middleware('auth:sanctum')->put('usuarios/{id}', [UserController::class, 'update']);
// Ruta para eliminar usuario
Route::middleware('auth:sanctum')->delete('usuarios/{id}', [UserController::class, 'delete']);