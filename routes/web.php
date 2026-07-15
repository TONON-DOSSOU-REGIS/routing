<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Auth\LoginLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Legacy language switcher URL kept for backward compatibility
Route::match(['GET', 'POST'], '/language/{locale}', function (string $locale) {
    return redirect('/' . $locale);
})->where(['locale' => 'en|fr|de|nl|es|pl|it']);

// Routes sans préfixe de langue (redirection vers la langue par défaut)
Route::get('/', function () {
    $locale = session('locale', config('app.locale', 'fr'));
    return redirect('/' . $locale);
});

Route::get('/login', function () {
    $locale = session('locale', config('app.locale', 'fr'));
    return redirect('/' . $locale . '/login');
});

Route::get('/register', function () {
    $locale = session('locale', config('app.locale', 'fr'));
    return redirect('/' . $locale . '/register');
});

Route::get('/home', function () {
    $locale = session('locale', config('app.locale', 'fr'));
    return redirect('/' . $locale . '/home');
});

// Routes avec préfixe de langue
Route::get('/sitemap.xml', function () {
    $locales = config('app.available_locales', ['fr', 'en']);
    $publicRoutes = [
        'home',
        'about.notre-histoire',
        'about.carrieres',
        'about.presse',
        'about.blog',
        'services.comptes-professionnels',
        'services.gestion-tresorerie',
        'services.cartes-paiement',
        'services.virements-internationaux',
        'support.securite',
        'support.mentions-legales',
        'support.centre-aide',
        'support.nous-contacter',
    ];

    $escapeXml = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    $lastModified = now()->toDateString();
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . PHP_EOL;

    foreach ($publicRoutes as $routeName) {
        foreach ($locales as $locale) {
            $url = route($routeName, ['locale' => $locale]);
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . $escapeXml($url) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $lastModified . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>' . ($routeName === 'home' ? 'weekly' : 'monthly') . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . ($routeName === 'home' ? '1.0' : '0.8') . '</priority>' . PHP_EOL;

            foreach ($locales as $alternateLocale) {
                $alternateUrl = route($routeName, ['locale' => $alternateLocale]);
                $xml .= '    <xhtml:link rel="alternate" hreflang="' . $escapeXml($alternateLocale) . '" href="' . $escapeXml($alternateUrl) . '" />' . PHP_EOL;
            }

            $defaultUrl = route($routeName, ['locale' => config('app.locale', 'fr')]);
            $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $escapeXml($defaultUrl) . '" />' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }
    }

    $xml .= '</urlset>' . PHP_EOL;

    return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

Route::prefix('{locale}')->where(['locale' => 'en|fr|de|nl|es|pl|it'])->group(function () {
    
    // Home
    Route::get('/', function () {
        return view('home');
    })->name('home');
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

    
    // Auth routes
    Auth::routes();

    // Login link (shortcut to login page)
    Route::get('/login-link/{token}', [LoginLinkController::class, 'login'])->name('login.link');
    Route::get('/l/{token}', [LoginLinkController::class, 'login'])->name('login.short');

    // Pending approval route
    Route::get('/pending-approval', function () {
        return view('auth.pending-approval');
    })->name('pending-approval');

    // Public routes
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

    Route::get('/services/comptes-professionnels', function () {
        return view('services.comptes-professionnels');
    })->name('services.comptes-professionnels');

    Route::get('/services/gestion-tresorerie', function () {
        return view('services.gestion-tresorerie');
    })->name('services.gestion-tresorerie');

    Route::get('/services/cartes-paiement', function () {
        return view('services.cartes-paiement');
    })->name('services.cartes-paiement');

    Route::get('/services/virements-internationaux', function () {
        return view('services.virements-internationaux');
    })->name('services.virements-internationaux');

    Route::get('/support/securite', function () {
        return view('support.securite');
    })->name('support.securite');

    Route::get('/support/mentions-legales', function () {
        return view('support.mentions-legales');
    })->name('support.mentions-legales');

    Route::get('/support/centre-aide', function () {
        return view('support.centre-aide');
    })->name('support.centre-aide');

    Route::get('/support/nous-contacter', [ContactController::class, 'create'])->name('support.nous-contacter');
    Route::post('/support/nous-contacter', [ContactController::class, 'store'])->name('support.nous-contacter.store');
    Route::get('/support/contact-thank-you', [ContactController::class, 'thankYou'])->name('support.nous-contacter.thankyou');

    Route::middleware(['auth'])->group(function () {
        // Two-Factor Authentication
        Route::get('/two-factor/setup', [TwoFactorController::class, 'setup'])->name('twofactor.setup');
        Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('twofactor.enable');
        Route::post('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('twofactor.disable');
        Route::get('/two-factor/challenge', [TwoFactorController::class, 'challenge'])->name('twofactor.challenge');
        Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('twofactor.verify');
    });

    // Authenticated routes (client space only)
    Route::middleware(['auth', 'twofactor', 'notAdmin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

        // Transfer & Transactions
        Route::get('/transfer/create', [TransactionController::class, 'create'])->name('transfer.create');
        Route::post('/transfer/start', [TransactionController::class, 'start'])->name('transfer.start');

        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions/start', [TransactionController::class, 'start'])->name('transactions.start');
        Route::post('/transactions/progress', [TransactionController::class, 'progress'])->name('transactions.progress');

        // Transactions (non sensitive)
        Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
        Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'receiptPdf'])->name('transactions.receipt');
        Route::get('/transactions/{transaction}/receipt-html', [TransactionController::class, 'receiptHtml'])->name('transactions.receipt.html');

    });

    // Notifications (client + admin)
    Route::middleware(['auth', 'twofactor'])->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/data', [NotificationController::class, 'getData'])->name('notifications.data');
        Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
        Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
        Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        Route::delete('/notifications/delete-all-read', [NotificationController::class, 'deleteAllRead'])->name('notifications.deleteAllRead');
    });

    // Admin routes
    Route::middleware(['auth', 'admin', 'twofactor'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard-with-chat', [AdminController::class, 'dashboardWithChat'])->name('dashboard-with-chat');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');
        Route::post('/password', [AdminController::class, 'updatePassword'])->name('password.update');

        // Users management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::post('/users/{user}/login-link', [AdminController::class, 'generateLoginLink'])->name('users.login-link');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::match(['POST', 'PATCH'], '/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('users.approve');

        // Transactions management
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
        Route::post('/transactions/{transaction}/refund', [AdminController::class, 'refundTransaction'])->name('transactions.refund');

        // Deposits
        Route::get('/deposit', [AdminController::class, 'depositForm'])->name('deposit');
        Route::post('/deposit', [AdminController::class, 'depositStore'])->name('deposit.store');

        // Exports
        Route::get('/export/pdf', [AdminController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [AdminController::class, 'exportExcel'])->name('export.excel');

    });
});

// Chat Routes (outside locale prefix for AJAX compatibility)
Route::middleware(['auth', 'twofactor'])->prefix('chat')->name('chat.')->group(function () {
    Route::post('/send', [ChatController::class, 'sendMessage'])->name('send');
    Route::post('/typing', [ChatController::class, 'setTyping'])->name('typing');
    Route::get('/messages', [ChatController::class, 'getMessages'])->name('messages');
    Route::get('/messages/{userId}', [ChatController::class, 'getMessages'])->name('messages.user');
    Route::get('/users', [ChatController::class, 'getUsersForAdmin'])->name('users');
    Route::get('/unread-count', [ChatController::class, 'getUnreadCount'])->name('unread-count');
    Route::post('/mark-read/{userId}', [ChatController::class, 'markAsRead'])->name('mark-read');
});
