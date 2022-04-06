<?php

use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(static function () {
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/login', [UserController::class, 'login'])->name('users.login');
    Route::post('/users/logout', [UserController::class, 'logout'])->name('users.logout');
    Route::middleware('auth:sanctum')->group(static function () {
        Route::apiResource('users', UserController::class)->except('store');
        Route::apiResource('products', ProductController::class);
    });
});
