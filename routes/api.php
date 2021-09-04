<?php

use Illuminate\Support\Facades\Route;


Route::resource('buyers', \App\Http\Controllers\BuyersController::class)
    ->only('index', 'show');

Route::resource('sellers', \App\Http\Controllers\SellersController::class)
    ->only('index', 'show');

Route::resource('users', \App\Http\Controllers\UsersController::class)
    ->except('create', 'edit');


Route::resource('categories', \App\Http\Controllers\CategoriesController::class)
    ->except('create', 'edit');
Route::resource('categories.products', \App\Http\Controllers\CategoryProductController::class)
    ->only('index');
Route::resource('categories.sellers', \App\Http\Controllers\CategoryProductController::class)
    ->only('index');
Route::resource('categories.transactions', \App\Http\Controllers\CategoryTransactionController::class)
    ->only('index');


Route::resource('transactions', \App\Http\Controllers\TransactionsController::class)
    ->only(['index', 'show']);

Route::resource(
    'transactions.categories',
    \App\Http\Controllers\TransactionCategoryController::class
    )->only(['index', 'show']);

Route::resource(
    'transactions.sellers',
    \App\Http\Controllers\TransactionSellerController::class
)->only(['index', 'show']);

Route::resource(
    'buyers.transactions',
    \App\Http\Controllers\BuyerTransactionController::class
)->only(['index', 'show']);

Route::resource(
    'buyers.products',
    \App\Http\Controllers\BuyerProductController::class
)->only(['index', 'show']);

Route::resource(
    'buyers.sellers',
    \App\Http\Controllers\BuyerSellerController::class
)->only(['index', 'show']);

Route::resource(
    'buyers.categories',
    \App\Http\Controllers\BuyerCategoryController::class
)->only(['index', 'show']);



