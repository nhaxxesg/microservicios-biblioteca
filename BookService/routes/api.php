<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\bookController;


Route::apiResource('book', bookController::class);  