<?php

use App\Http\Controllers\Api\PrestamosController;
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

Route::middleware('auth:sanctum')->group(function () {
    // Préstamos routes
    Route::get('/prestamos', [PrestamosController::class, 'index'])
        ->middleware('can:view-any,App\Models\Prestamo');
    
    Route::post('/prestamos', [PrestamosController::class, 'store'])
        ->middleware('can:create,App\Models\Prestamo');
    
    Route::get('/prestamos/{id}', [PrestamosController::class, 'show'])
        ->middleware('can:view,prestamo');
    
    Route::put('/prestamos/{id}', [PrestamosController::class, 'update'])
        ->middleware('can:update,prestamo');
    
    Route::delete('/prestamos/{id}', [PrestamosController::class, 'destroy'])
        ->middleware('can:delete,prestamo');
    
    Route::get('/prestamos/usuario/{user_id}', [PrestamosController::class, 'userLoans']);
});
