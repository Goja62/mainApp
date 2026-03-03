<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'showCorrectHomepage']);
Route::get('/single-post', [ExampleController::class, 'aboutPage']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'registerUser']);
