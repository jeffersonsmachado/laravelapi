<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);
 
//     return ['token' => $token->plainTextToken];
// });

Route::group([
    'prefix'     => 'v1',
    'as'         => 'api.',
    // 'namespace'  => 'Api\V1\Admin',
    // 'middleware' => ['auth:sanctum']
], function() {
    // Route::apiResource('expense', ExpenseController::class)->withTrashed();
    Route::post('login', 'App\\Http\\Controllers\\Api\\AuthController@login');
});