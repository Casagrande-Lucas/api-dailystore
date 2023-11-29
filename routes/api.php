<?php

use App\Http\Api\AuthController;
use App\Http\Api\ProductApi;
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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('home', [AuthController::class, 'login'])->name('auth-home');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth-logout');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('stock')->group(function () {
            Route::prefix('products')->group(function () {
                Route::middleware(['abilities:products-list'])->get('list', [ProductApi::class, 'list'])->name('products->list');
            });
        });
    });
});
