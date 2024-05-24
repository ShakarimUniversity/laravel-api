<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store']);
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/{user}', [\App\Http\Controllers\UserController::class, 'show']);
    });
});
Route::post('register',[\App\Http\Controllers\LoginController::class,'register']);
Route::post('login',[\App\Http\Controllers\LoginController::class,'login']);
