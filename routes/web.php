<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// User Related Routes
Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
Route::post('/register', [UserController::class, 'registerUser'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('mustBeLoggedIn');

// Post Related Routes
Route::get('/create-post', [PostController::class, 'showCreatePost'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');

//  Profile Relater Routes
Route::get('/profile/{user:username}', [UserController::class, 'profile']);
