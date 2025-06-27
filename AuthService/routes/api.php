<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

// Rutas para gestión de usuarios
Route::group([
    'prefix' => 'users'
], function () {
    // Listar usuarios (con filtro opcional por role_id)
    Route::get('/', [UserController::class, 'index']);
    
    // Crear nuevo usuario
    Route::post('/', [UserController::class, 'store']);
    
    // Obtener usuario por ID
    Route::get('/{id}', [UserController::class, 'show']);
    
    // Actualizar usuario
    Route::put('/{id}', [UserController::class, 'update']);
    
    // Eliminar usuario
    Route::delete('/{id}', [UserController::class, 'destroy']);
    
    // Filtrar usuarios específicamente por role_id = 1 (usuarios)
    Route::get('/filter/role-one', [UserController::class, 'getUsersByRoleOne']);
    
    // Filtrar usuarios específicamente por role_id = 2 (administradores)
    Route::get('/filter/role-two', [UserController::class, 'getUsersByRoleTwo']);
});
