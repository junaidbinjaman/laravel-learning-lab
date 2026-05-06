<?php

use App\Http\Controllers\API\TestApiController;
use App\Http\Controllers\API\StudentApiController;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;
//
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

// First API Route for

Route::get('/test', [TestApiController::class, 'test'])->name('test-api');

Route::apiResource('/students', StudentApiController::class);
