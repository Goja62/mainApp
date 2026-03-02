<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExampleController::class, 'homepage']);
Route::get('/single-post', [ExampleController::class, 'aboutPage']);

// Route::get('/register', [ExampleController::class, 'registerPage']);
Route::post('/register', [UserController::class, 'registerUser']);
