<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\NotificationController;

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

// Analytics API routes - Using web middleware for session-based auth
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/analytics/balance-evolution', [DashboardController::class, 'getBalanceEvolution']);
    Route::get('/analytics/transactions-by-type', [DashboardController::class, 'getTransactionsByType']);
    Route::get('/analytics/monthly-comparison', [DashboardController::class, 'getMonthlyComparison']);
    Route::get('/analytics/statistics', [DashboardController::class, 'getAnalyticsStatistics']);
});

// Market Data API routes
Route::middleware(['web', 'auth'])->prefix('market')->name('market.')->group(function () {
    Route::get('/all', [MarketController::class, 'index'])->name('all');
    Route::get('/crypto', [MarketController::class, 'crypto'])->name('crypto');
    Route::get('/stocks', [MarketController::class, 'stocks'])->name('stocks');
    Route::get('/forex', [MarketController::class, 'forex'])->name('forex');
    Route::post('/clear-cache', [MarketController::class, 'clearCache'])->name('clear-cache');
});

// Notifications API routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
});
