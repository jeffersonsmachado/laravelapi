<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\UserController;


Route::group([
    'prefix'     => 'v1',
    'as'         => 'api.',
], function() {
    Route::middleware('auth:sanctum')->apiResource('user', UserController::class);
    Route::middleware('auth:sanctum')->apiResource('expense', ExpenseController::class);
    Route::post('login', 'App\\Http\\Controllers\\Api\\AuthController@login');
});