<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\BlogCategoryController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\TestApiController;
use App\Http\Controllers\API\BlogPostController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');'

Route::middleware('throttle:api')->get('test', [TestApiController::class, 'test'])->name('test-api');
Route::apiResource('/students', StudentApiController::class);

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum', 'throttle:api'], function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Blog category routes
    Route::apiResource('categories', BlogCategoryController::class)->middleware(['role:admin']);

    // Blog post routes
    Route::apiResource('posts', BlogPostController::class)->middleware(['role:admin,author']);
    Route::post('/blog-post-image/{post}', [BlogPostController::class, 'blogPostImage'])->name('blog-post-image')->middleware('role:admin,author');

    Route::middleware('throttle:reactions')->post('post/react', [LikeController::class, 'react'])->name('react');
    Route::apiResource('comments', CommentController::class);

    Route::get('comments', [CommentController::class, 'index'])->name('index')->middleware('role:admin');
    Route::post('comments/change-status', [CommentController::class, 'changeStatus'])->name('change-status')->middleware('role:admin');

    Route::get('comments/{comment}', [CommentController::class, 'destroy'])->name('destroy')->middleware('role:admin');
});

Route::get('categories', [BlogCategoryController::class, 'index']);
Route::get('posts', [BlogPostController::class, 'index']);
Route::get('post/reactions/{post}', [LikeController::class, 'reactions'])->name('reactions');
Route::get('comments/{comment}', [CommentController::class, 'show'])->name('show');
