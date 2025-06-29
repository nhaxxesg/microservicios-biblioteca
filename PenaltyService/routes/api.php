<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SancionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas protegidas por autenticación
Route::apiResource('sanciones', SancionController::class);
Route::get('sanciones/usuario/{usuario_id}', [SancionController::class, 'porUsuario']);
Route::get('sanciones/libro/{book_id}', [SancionController::class, 'porLibro']);
