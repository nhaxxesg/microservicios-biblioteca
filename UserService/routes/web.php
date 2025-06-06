<?php

use Illuminate\Support\Facades\Route;

// Como este es un servicio API, redirigimos cualquier acceso web a una respuesta JSON apropiada
Route::any('{any}', function () {
    return response()->json(['message' => 'Not Found'], 404);
})->where('any', '.*');