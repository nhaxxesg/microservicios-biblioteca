<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\bookController;

Route::get('/', function () {
    return view('welcome');
});
