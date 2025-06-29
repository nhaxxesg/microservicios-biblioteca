<?php

use App\Http\Controllers\Api\LoansController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('prestamos',[LoansController::class, 'index']);
Route::get('prestamos/usuario/{id_usuario}', [LoansController::class, 'prestamosPorUsuario']);
Route::get('prestamos/{id}', [LoansController::class, 'show']);
Route::post('prestamos', [LoansController::class, 'store']);
Route::put('prestamos/{id}', [LoansController::class, 'update']);
