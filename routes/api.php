<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Api\UserController;


Route::group([
    'prefix'     => 'v1',
    'as'         => 'api.',
    // 'namespace'  => 'Api\V1\Admin',
    // 'middleware' => ['auth:sanctum']
], function() {
    // Route::apiResource('expense', ExpenseController::class)->withTrashed();
    Route::post('login', 'App\\Http\\Controllers\\Api\\AuthController@login');
    Route::middleware('auth:sanctum')->apiResource('user', UserController::class);
});