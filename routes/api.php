<?php

use Illuminate\Support\Facades\Route;

/**
 * Buyer Routes
 */

Route::resource(
    'buyers.transactions',
    \App\Http\Controllers\Buyer\BuyerTransactionController::class
)->only(['index', 'show']);

Route::resource(
    'buyers.products',
    \App\Http\Controllers\Buyer\BuyerProductController::class
)->only(['index', 'show']);

Route::resource(
    'buyers.sellers',
    \App\Http\Controllers\Buyer\BuyerSellerController::class
)->only(['index', 'show']);

Route::resource(
    'buyers.categories',
    \App\Http\Controllers\Buyer\BuyerCategoryController::class
)->only(['index', 'show']);

Route::resource('buyers', \App\Http\Controllers\Buyer\BuyersController::class)
    ->only('index', 'show');


/**
 * Category Routes
 */

Route::resource('categories', \App\Http\Controllers\Category\CategoriesController::class)
    ->except('create', 'edit');
Route::resource('categories.products', \App\Http\Controllers\Category\CategoryProductController::class)
    ->only('index');
Route::resource('categories.sellers', \App\Http\Controllers\Category\CategoryProductController::class)
    ->only('index');
Route::resource('categories.transactions', \App\Http\Controllers\Category\CategoryTransactionController::class)
    ->only('index');
Route::resource('categories.buyers', \App\Http\Controllers\Category\CategoryBuyerController::class)
    ->only('index');


/**
 * Product Routes
 */

Route::resource('products',\App\Http\Controllers\Product\ProductsController::class)
    ->only('index','show');



/**
 * Seller Routes
 */

Route::resource('sellers', \App\Http\Controllers\Seller\SellersController::class)
    ->only('index', 'show');
Route::resource('sellers.transactions', \App\Http\Controllers\Seller\SellerTransactionController::class)
    ->only('index');
Route::resource('sellers.categories', \App\Http\Controllers\Seller\SellerCategoryController::class)
    ->only('index');
Route::resource('sellers.buyers', \App\Http\Controllers\Seller\SellerBuyerController::class)
    ->only('index');
Route::resource('sellers.products', \App\Http\Controllers\Seller\SellerProductController::class)
    ->except('edit', 'create', 'show');

/**
 * Transaction Routes
 */

Route::resource('transactions', \App\Http\Controllers\Transaction\TransactionsController::class)
    ->only(['index', 'show']);

Route::resource(
    'transactions.categories',
    \App\Http\Controllers\Transaction\TransactionCategoryController::class
)->only(['index', 'show']);

Route::resource(
    'transactions.sellers',
    \App\Http\Controllers\Transaction\TransactionSellerController::class
)->only(['index', 'show']);


/**
 * User Routes
 */

Route::resource('users', \App\Http\Controllers\User\UsersController::class)
    ->except('create', 'edit');







