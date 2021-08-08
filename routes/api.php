<?php

use Illuminate\Support\Facades\Route;


Route::resource('buyers', \App\Http\Controllers\BuyersController::class)
    ->only('index', 'show');

Route::resource('users', \App\Http\Controllers\UsersController::class)
    ->except('create', 'edit');
