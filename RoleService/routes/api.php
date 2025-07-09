<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


    // Role management routes
Route::apiResource('roles', RoleController::class);
    
    // Role assignment routes
Route::post('roles/assign', [RoleController::class, 'assignRole']);
Route::get('users/{userId}/role', [RoleController::class, 'getUserRole']);
Route::delete('users/{userId}/role', [RoleController::class, 'removeUserRole']);
