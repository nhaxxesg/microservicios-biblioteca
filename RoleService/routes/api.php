<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

// Protected Routes
Route::middleware('auth:api')->group(function () {
    // Role management routes
    Route::apiResource('roles', RoleController::class);
    
    // Role assignment routes
    Route::post('roles/assign', [RoleController::class, 'assignRole']);
    Route::get('users/{userId}/role', [RoleController::class, 'getUserRole']);
    Route::delete('users/{userId}/role', [RoleController::class, 'removeUserRole']);
});
