<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('api')->middleware(['api', 'auth:sanctum'])->group(function () {
    Route::post('/notifications/send', [NotificationController::class, 'send']);
    Route::get('notifications', [NotificationController::class, 'index']);
});
