<?php

use Illuminate\Support\Facades\Route;


Route::resource('buyers', \App\Http\Controllers\BuyersController::class)
    ->only('index', 'show');

Route::resource('sellers', \App\Http\Controllers\SellersController::class)
    ->only('index', 'show');

Route::resource('transactions', \App\Http\Controllers\TransactionsController::class)
    ->only(['index', 'show']);

Route::resource('categories', \App\Http\Controllers\CategoriesController::class)
    ->except('create', 'edit');

Route::resource('users', \App\Http\Controllers\UsersController::class)
    ->except('create', 'edit');


