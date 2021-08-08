<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource('buyers', \App\Http\Controllers\BuyersController::class)
    ->only('index', 'show');
