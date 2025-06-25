<?php

use App\Http\Controllers\CategoriasLibrosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('categoriaLibros',CategoriasLibrosController::class);