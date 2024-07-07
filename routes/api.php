<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
  

Route::middleware('auth:sanctum')->get('/users', [App\Http\Controllers\Api\V1\UserController::class, 'show']);
Route::post('/login', [App\Http\Controllers\Api\V1\LoginController::class,'login']);


Route::middleware('auth:sanctum')->get('/customers', [App\Http\Controllers\Api\V1\CustomersController::class, 'GetCustomers']);
Route::middleware('auth:sanctum')->get('/customer', [App\Http\Controllers\Api\V1\CustomersController::class, 'GetCustomer']);
Route::middleware('auth:sanctum')->post('/add/customer', [App\Http\Controllers\Api\V1\CustomersController::class, 'InsertCustomer']);
Route::middleware('auth:sanctum')->delete('/delete/{customer}', [App\Http\Controllers\Api\V1\CustomersController::class, 'delete']);


