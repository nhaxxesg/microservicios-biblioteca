<?php

use App\Http\Controllers\Api\AutoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('Autores',[AutoresController::class, 'index']);
Route::get('Autores/{id}', [AutoresController::class, 'show']);
Route::post('Autores', [AutoresController::class, 'store']);
Route::put('Autores/{id}', [AutoresController::class, 'update']);

