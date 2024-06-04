<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans-callback', [TransactionController::class, 'afterPayments']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);