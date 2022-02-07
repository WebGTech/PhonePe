<?php

use App\Http\Controllers\FareController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Qr\DashboardController;
use App\Http\Controllers\Qr\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::post('login', [MainController::class, 'login']);

// SJT RJT
Route::get('qr/dashboard', [DashboardController::class, 'index']);
Route::get('qr/order', [OrderController::class, 'index']);
Route::post('qr/order/create', [OrderController::class, 'create']);
