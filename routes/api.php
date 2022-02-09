<?php

use App\Http\Controllers\FareController;
use Illuminate\Support\Facades\Route;

Route::post('/get/fare', [FareController::class, 'getFare'])->name('fare');
