<?php

use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/checkout', [TransactionController::class, 'create']);

Route::post('/midtrans-callback', [TransactionController::class, 'afterPayments']);
Route::get('/transactions', [TransactionController::class, 'viewTransactions']);
