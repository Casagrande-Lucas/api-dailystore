<?php

use App\Http\Controllers\AuthController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth-login');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth-logout');
    });

    Route::prefix('stock')->middleware(['auth:sanctum', 'abilities:stock-exec'])->group(function () {
        Route::post('product', []);
    });
});
