<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\bookController;

Route::get('book', [bookController::class, 'index']);
Route::post('book', [bookController::class, 'store']);
Route::get('book/{id}', [bookController::class, 'show']);
Route::put('book/{id}', [bookController::class, 'update']);
Route::post('bookCategories', [bookController::class, 'storeWithCategories']);