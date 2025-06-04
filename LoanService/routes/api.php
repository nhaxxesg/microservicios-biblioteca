<?php

use App\Http\Controllers\Api\PrestamosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Préstamos routes
Route::get('/prestamos', [PrestamosController::class, 'index']);

Route::post('/prestamos', [PrestamosController::class, 'store']);

Route::get('/prestamos/{id}', [PrestamosController::class, 'show']);

Route::put('/prestamos/{id}', [PrestamosController::class, 'update']);

Route::delete('/prestamos/{id}', [PrestamosController::class, 'destroy']);

Route::get('/prestamos/usuario/{user_id}', [PrestamosController::class, 'userLoans']);
