<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Ticket\DashboardController;
use App\Http\Controllers\Ticket\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::post('/auth', [IndexController::class, 'fetchAccessToken'])->name('auth');

// PRODUCTS
Route::get('/products', [ProductController::class, 'index'])->name('products');

// SJT RJT TICKET
Route::get('/ticket/dashboard', [DashboardController::class, 'index'])->name('ticket.dashboard');
Route::get('/ticket/order', [OrderController::class, 'index'])->name('ticket.order');
Route::post('/ticket/create', [OrderController::class, 'create'])->name('ticket.create');
Route::get('/ticket/view', [OrderController::class, 'view'])->name('ticket.view');

//PAYMENT
Route::get('/pay/{oid}', [PaymentController::class, 'index']);
