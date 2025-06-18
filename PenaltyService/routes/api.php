<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SancionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth.jwt')->group(function () {
    // Rutas protegidas por autenticación
    Route::apiResource('sanciones', SancionController::class);
    Route::get('sanciones/usuario/{usuario_id}', [SancionController::class, 'porUsuario']);
});
