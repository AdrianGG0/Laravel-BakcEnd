<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [App\Http\Controllers\Api\V1\LoginController::class, 'auth'])->name('login');
