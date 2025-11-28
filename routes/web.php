<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'home'])->name('home');

// Static pages
Route::get('/services/comptes-professionnels', function () {
    return view('services.comptes-professionnels');
})->name('services.comptes-professionnels');

Route::get('/services/virements-internationaux', function () {
    return view('services.virements-internationaux');
})->name('services.virements-internationaux');

Route::get('/services/gestion-tresorerie', function () {
    return view('services.gestion-tresorerie');
})->name('services.gestion-tresorerie');

Route::get('/services/cartes-paiement', function () {
    return view('services.cartes-paiement');
})->name('services.cartes-paiement');

Route::get('/about/notre-histoire', function () {
    return view('about.notre-histoire');
})->name('about.notre-histoire');

Route::get('/about/carrieres', function () {
    return view('about.carrieres');
})->name('about.carrieres');

Route::get('/about/presse', function () {
    return view('about.presse');
})->name('about.presse');

Route::get('/about/blog', function () {
    return view('about.blog');
})->name('about.blog');

Route::get('/support/centre-aide', function () {
    return view('support.centre-aide');
})->name('support.centre-aide');

Route::get('/support/nous-contacter', function () {
    return view('support.nous-contacter');
})->name('support.nous-contacter');

use App\Http\Controllers\ContactController;

Route::post('/support/nous-contacter', [ContactController::class, 'store'])->name('support.nous-contacter.store');
Route::get('/support/nous-contacter/merci', [ContactController::class, 'thankYou'])->name('support.nous-contacter.thankyou');

Route::get('/support/securite', function () {
    return view('support.securite');
})->name('support.securite');

Route::get('/support/mentions-legales', function () {
    return view('support.mentions-legales');
})->name('support.mentions-legales');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::get('/transfer', [TransactionController::class, 'create'])->name('transfer.create');
    Route::post('/transfer/start', [TransactionController::class, 'start'])->name('transfer.start');
    Route::post('/transfer/progress', [TransactionController::class, 'progress'])->name('transfer.progress');
    Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'receiptPdf'])->name('transactions.receipt');

    // New route for HTML receipt view
    Route::get('/transactions/{transaction}/receipt-html', [TransactionController::class, 'receiptHtml'])->name('transactions.receipt.html');

    // Chat routes
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{userId?}', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::get('/chat/unread-count', [App\Http\Controllers\ChatController::class, 'getUnreadCount'])->name('chat.unread');
    Route::post('/chat/mark-read/{userId}', [App\Http\Controllers\ChatController::class, 'markAsRead'])->name('chat.markRead');

    // Analytics API routes
    Route::prefix('api/analytics')->group(function () {
        Route::get('/balance-evolution', [App\Http\Controllers\AnalyticsController::class, 'getBalanceEvolution'])->name('api.analytics.balance');
        Route::get('/transactions-by-type', [App\Http\Controllers\AnalyticsController::class, 'getTransactionsByType'])->name('api.analytics.types');
        Route::get('/monthly-comparison', [App\Http\Controllers\AnalyticsController::class, 'getMonthlyComparison'])->name('api.analytics.monthly');
        Route::get('/statistics', [App\Http\Controllers\AnalyticsController::class, 'getStatistics'])->name('api.analytics.statistics');
    });

    // Market Data API routes
    Route::prefix('api/market')->group(function () {
        Route::get('/all', [App\Http\Controllers\MarketDataController::class, 'index'])->name('api.market.all');
        Route::get('/crypto', [App\Http\Controllers\MarketDataController::class, 'crypto'])->name('api.market.crypto');
        Route::get('/stocks', [App\Http\Controllers\MarketDataController::class, 'stocks'])->name('api.market.stocks');
        Route::get('/forex', [App\Http\Controllers\MarketDataController::class, 'forex'])->name('api.market.forex');
        Route::post('/clear-cache', [App\Http\Controllers\MarketDataController::class, 'clearCache'])->name('api.market.clear-cache');
    });

    // KYC routes
    Route::get('/kyc', [App\Http\Controllers\KycController::class, 'index'])->name('kyc.index');
    Route::post('/kyc/submit', [App\Http\Controllers\KycController::class, 'submit'])->name('kyc.submit');
    Route::get('/kyc/status', [App\Http\Controllers\KycController::class, 'status'])->name('kyc.status');
});

// Notifications routes
Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/recent', [App\Http\Controllers\NotificationController::class, 'recent'])->name('notifications.recent');
    Route::post('/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/read/all', [App\Http\Controllers\NotificationController::class, 'deleteAllRead'])->name('notifications.delete-all-read');
    Route::post('/test', [App\Http\Controllers\NotificationController::class, 'createTest'])->name('notifications.test');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard-with-chat', [AdminController::class, 'dashboardWithChat'])->name('admin.dashboard.withChat');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'saveSettings'])->name('admin.settings.save');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/users/{user}/status', [AdminController::class, 'toggleUser'])->name('admin.users.toggle');

    Route::patch('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');

    Route::get('/deposit', [AdminController::class, 'depositForm'])->name('admin.deposit');
    Route::post('/deposit', [AdminController::class, 'depositStore'])->name('admin.deposit.store');

    Route::get('/transactions/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');
    Route::get('/transactions/export/excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');

    Route::patch('/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');

    // Transaction management routes
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/transactions/{transaction}/refund', [AdminController::class, 'refundTransaction'])->name('admin.transactions.refund');

});

