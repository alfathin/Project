<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('login', [
//         'titlePage' => 'Login'
//     ]);
// });

Route::get('/',[UserController::class, 'loginView']);
Route::get('/register',[UserController::class, 'registerView']);

Route::post('/',[UserController::class, 'login']);
Route::post('/register',[UserController::class, 'register']);
Route::post('/logout',[UserController::class, 'logout']);

Route::middleware('role:admin')->group(function () {
    Route::get('/admin',[UserController::class, 'adminView']);
    
    Route::get('/admin/categories',[CategoryController::class, 'adminCategoriesView']);
    Route::post('/admin/categories',[CategoryController::class, 'adminAddCategory']);
    Route::delete('/admin/category/{id}',[CategoryController::class, 'adminDeleteCategory']);
    Route::post('/admin/categoryEdit/{id}',[CategoryController::class, 'adminEditCategory']);
    
    Route::get('/admin/products',[ProductController::class, 'adminProductsView']);
    Route::get('/admin/productsCategory/{name}',[ProductController::class, 'adminProductsByCategory']);
    Route::post('/admin/products',[ProductController::class, 'adminAddProduct']);
    Route::delete('/admin/product/{id}',[ProductController::class, 'adminDeleteProduct']);
    Route::post('/admin/productEdit/{id}',[ProductController::class, 'adminEditProduct']);

    Route::get('/admin/transactions', [TransactionController::class, 'adminViewTransaction']);

    Route::get('/admin/costumer', [UserController::class, 'adminViewCostumer']);
    Route::get('/report', [ChartController::class, 'index']); 
});

Route::get('/home',[UserController::class, 'homeView']);
Route::get('/products',[ProductController::class, 'productsView']);
Route::get('/productsCategory/{name}',[ProductController::class, 'productsByCategory']);
Route::get('/product/{id}',[ProductController::class, 'productById']);

Route::get('/carts',[CartController::class, 'cartsView']);
Route::post('/carts',[CartController::class, 'addToCart']);
Route::delete('/deleteCart',[CartController::class, 'deleteCart']);

Route::post('/checkout', [TransactionController::class, 'checkoutProduct']);
Route::get('/transactions', [TransactionController::class, 'viewTransactions']);

Route::get('/invoices', [TransactionController::class, 'viewInvoices']);

Route::post('/ratings', [RatingController::class, 'store'])->middleware('auth');

Route::get('/profile', [UserController::class, 'viewProfile']);
Route::post('/editProfile/{id}', [UserController::class, 'editProfile']);
