<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/available-cars', [CarController::class, 'available']);
//    Route::get('/user', fn(\Illuminate\Http\Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
});

