<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\OrderController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//check order status
Route::get('/order-status/{id}', [OrderController::class, 'status']);

Route::middleware('auth:sanctum')->post('/new-order', [OrderController::class, 'create']);
