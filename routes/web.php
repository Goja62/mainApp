<?php

use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExampleController::class, 'homepage']);
Route::get('/about', [ExampleController::class, 'about']);
