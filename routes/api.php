<?php

use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

Route::get('/available-cars', [CarController::class, 'available']);
