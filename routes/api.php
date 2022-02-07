<?php

use App\Http\Controllers\FareController;
use Illuminate\Support\Facades\Route;

// FARE
Route::post('fare', [FareController::class, 'fare']);
