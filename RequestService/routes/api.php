<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudesController;

Route::get('solicitudes',[SolicitudesController::class, 'index']);
Route::post('solicitudes',[SolicitudesController::class, 'store']);
Route::get('solicitudes/usuario/{id_usuario}',[SolicitudesController::class, 'solicitudesPorUsuario']);
Route::get('solicitudes/{id}',[SolicitudesController::class, 'show']);
Route::put('solicitudes/{id}',[SolicitudesController::class, 'update']);

