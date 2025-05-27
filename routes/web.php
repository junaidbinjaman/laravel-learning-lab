<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');

// User related routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost']);
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);

// Profile related routes
Route::get('/profile/{pizza:username}', [UserController::class, 'profile']);

