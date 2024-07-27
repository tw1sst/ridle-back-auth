<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\SchoolController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});


Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    Route::get('/school', [SchoolController::class, 'index']);
    Route::post('/school', [SchoolController::class, 'store']);
    Route::get('/school/{id}', [SchoolController::class, 'show']);
    Route::put('/school/{id}', [SchoolController::class, 'update']);
    Route::delete('/school/{id}', [SchoolController::class, 'destroy']);
});
