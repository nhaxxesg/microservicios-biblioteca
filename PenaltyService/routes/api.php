<?php

use App\Http\Controllers\SancionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('sanciones', SancionController::class);
// Route::get('sanciones', [SancionController::class, 'index']);
// Route::post('sanciones', [SancionController::class, 'store']);
// Route::get('sanciones/{id}', [SancionController::class, 'show']);   
// Route::put('sanciones/{id}', [SancionController::class, 'update']);
