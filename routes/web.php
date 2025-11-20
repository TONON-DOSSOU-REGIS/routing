<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'saveSettings'])->name('admin.settings.save');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/users/{user}/status', [AdminController::class, 'toggleUser'])->name('admin.users.toggle');

    Route::get('/deposit', [AdminController::class, 'depositForm'])->name('admin.deposit');
    Route::post('/deposit', [AdminController::class, 'depositStore'])->name('admin.deposit.store');

    Route::get('/transactions/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');
    Route::get('/transactions/export/excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');

    Route::patch('/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');
});
