<?php
use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/available-cars', [CarController::class, 'available']);
