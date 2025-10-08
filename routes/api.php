<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogCategoryController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\TestApiController;
use App\Http\Controllers\API\BlogPostController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');'

Route::get('test', [TestApiController::class, 'test'])->name('test-api');
Route::apiResource('/students', StudentApiController::class);

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Blog category routes
    Route::apiResource('categories', BlogCategoryController::class)->middleware(['role:admin']);

    // Blog post routes
    Route::apiResource('posts', BlogPostController::class)->middleware(['role:admin,author']);
    Route::post('/blog-post-image/{post}', [BlogPostController::class, 'blogPostImage'])->name('blog-post-image')->middleware('role:admin,author');

    Route::post('post/react', [LikeController::class, 'react'])->name('react');
});

Route::get('categories', [BlogCategoryController::class, 'index']);
Route::get('posts', [BlogPostController::class, 'index']);
Route::get('post/reactions/{post}', [LikeController::class, 'reactions'])->name('reactions');
