<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// Ruta para enviar notificaciones por email
Route::post('/notifications/send', [NotificationController::class, 'send'])->middleware(['api', 'auth:sanctum']);

// Rutas para el CRUD de notificaciones de usuarios
Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::get('/users/{userId}/notifications', [UserNotificationController::class, 'index']);
    Route::get('/users/{userId}/notifications/count-unread', [UserNotificationController::class, 'countUnread']);
    Route::post('/notifications/user', [UserNotificationController::class, 'store']);
    Route::get('/notifications/user/{id}', [UserNotificationController::class, 'show']);
    Route::put('/notifications/user/{id}', [UserNotificationController::class, 'update']);
    Route::delete('/notifications/user/{id}', [UserNotificationController::class, 'destroy']);
    Route::patch('/notifications/user/{id}/read', [UserNotificationController::class, 'markAsRead']);

});
