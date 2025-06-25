<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificacionesController;

Route::get('notificaciones',[NotificacionesController::class , 'index']);
Route::post('notificaciones',[NotificacionesController::class , 'store']);
Route::get('notificaciones/{id}',[NotificacionesController::class , 'show']);
Route::put('notificaciones/{id}',[NotificacionesController::class , 'update']);