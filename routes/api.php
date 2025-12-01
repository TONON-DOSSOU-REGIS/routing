<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Analytics API routes
Route::middleware(['auth'])->group(function () {
    Route::get('/analytics/balance-evolution', [DashboardController::class, 'getBalanceEvolution']);
    Route::get('/analytics/transactions-by-type', [DashboardController::class, 'getTransactionsByType']);
    Route::get('/analytics/monthly-comparison', [DashboardController::class, 'getMonthlyComparison']);
    Route::get('/analytics/statistics', [DashboardController::class, 'getAnalyticsStatistics']);
});
