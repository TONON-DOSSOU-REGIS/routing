<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
});
