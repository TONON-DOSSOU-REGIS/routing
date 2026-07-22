<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Mail\PasswordResetMail;
use App\Models\ChatMessage;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\UserRegistrationNotification;
use App\Mail\UserApprovedNotification;
use App\Mail\TransactionRefundedMail;
use App\Services\NotificationService;
use App\Support\PhoneNumber;

class AdminController extends Controller
{
    public function index($locale)
    {
        $admin = auth()->user();
        $thirtyDaysAgo = now()->subDays(30);

        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $pendingUsersCount = User::where('status', 'pending')->count();
        $suspendedUsersCount = User::where('status', 'suspended')->count();
        $totalTransactions = Transaction::count();
        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');
        $totalTransfers = Transaction::where('type', 'transfer')->sum('amount');
        $monthlyDeposits = Transaction::where('type', 'deposit')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('amount');
        $monthlyTransfers = Transaction::where('type', 'transfer')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('amount');
        $pendingTransactionsCount = Transaction::whereIn('status', ['pending', 'on_hold'])->count();
        $successfulTransactionsCount = Transaction::where('status', 'success')->count();
        $transactionSuccessRate = $totalTransactions > 0
            ? (int) round(($successfulTransactionsCount / $totalTransactions) * 100)
            : 100;
        $unreadNotificationsCount = $admin ? $admin->unreadNotifications()->count() : 0;
        $chatUnreadCount = $admin
            ? ChatMessage::where('receiver_id', $admin->id)->unread()->count()
            : 0;
        $recentTransactions = Transaction::with('user')->latest()->take(6)->get();
        $pendingUsers = User::where('status', 'pending')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $activeUsersRate = $totalUsers > 0
            ? (int) round(($activeUsers / $totalUsers) * 100)
            : 0;

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'pendingUsersCount',
            'suspendedUsersCount',
            'totalTransactions',
            'totalDeposits',
            'totalWithdrawals',
            'totalTransfers',
            'monthlyDeposits',
            'monthlyTransfers',
            'pendingTransactionsCount',
            'transactionSuccessRate',
            'unreadNotificationsCount',
            'chatUnreadCount',
            'recentTransactions',
            'pendingUsers',
            'recentUsers',
            'activeUsersRate'
        ));
    }

    public function dashboardWithChat()
    {
        // Fetch active users excluding current admin (you can adjust as needed)
        $users = User::where('status', 'active')
                     ->where('id', '!=', auth()->id())
                     ->orderBy('first_name')
                     ->get();

        return view('admin.dashboard_with_chat', compact('users'));
    }

    public function settings($locale)
    {
        $settings = Setting::first();
        $users = User::where('role', 'user')->orderBy('first_name')->get();

        return view('admin.settings', array_merge(
            compact('settings', 'users'),
            $this->getAdminShellData()
        ));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'stop_percentage' => 'required|integer|between:0,100',
            'stop_message' => 'required|string',
            'target_user_id' => 'nullable|exists:users,id',
            'is_global' => 'required|boolean',
        ]);

        $settings = Setting::first();
        
        // Create settings if it doesn't exist
        if (!$settings) {
            $settings = Setting::create([
                'stop_percentage' => $request->stop_percentage,
                'stop_message' => $request->stop_message,
                'target_user_id' => $request->target_user_id,
                'is_global' => $request->is_global,
            ]);
        } else {
            $settings->update($request->only(['stop_percentage', 'stop_message', 'target_user_id', 'is_global']));
        }

        Log::info('Admin updated settings', [
            'admin_id' => auth()->id(),
            'stop_percentage' => $request->stop_percentage,
            'stop_message' => $request->stop_message,
            'target_user_id' => $request->target_user_id,
            'is_global' => $request->is_global,
        ]);

        return back()->with('status', __('system_messages.admin_settings_updated'));
    }

    public function updatePassword($locale, Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed|different:current_password',
        ], [
            'current_password.required' => __('system_messages.current_password_required'),
            'new_password.required' => __('system_messages.new_password_required'),
            'new_password.min' => __('system_messages.new_password_min'),
            'new_password.confirmed' => __('system_messages.new_password_confirmed'),
            'new_password.different' => __('system_messages.new_password_different'),
        ]);

        $admin = auth()->user();

        if (!$admin || !Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => __('system_messages.current_password_invalid'),
            ]);
        }

        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        Log::info('Admin updated own password', [
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
        ]);

        return back()->with('status', __('system_messages.admin_password_updated'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users', array_merge(
            compact('users'),
            $this->getAdminShellData()
        ));
    }

    public function toggleUser($locale, User $user)
    {
        $user->update(['status' => $user->status === 'active' ? 'suspended' : 'active']);

        Log::info('Admin toggled user status', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'new_status' => $user->status,
        ]);

        return back()->with('status', __('system_messages.admin_user_status_updated'));
    }

    public function depositForm($locale)
    {
        $users = User::where('role', 'user')->orderBy('first_name')->get();
        $recentDeposits = Transaction::with('user')
            ->where('type', 'deposit')
            ->latest()
            ->take(6)
            ->get();
        $depositVolume30Days = Transaction::where('type', 'deposit')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('amount');
        $depositsTodayCount = Transaction::where('type', 'deposit')
            ->whereDate('created_at', today())
            ->count();

        return view('admin.deposit', array_merge(
            compact('users', 'recentDeposits', 'depositVolume30Days', 'depositsTodayCount'),
            $this->getAdminShellData()
        ));
    }

    public function depositStore(DepositRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::findOrFail($request->user_id);

            // Always update default_currency to the chosen currency
            $user->default_currency = $request->currency;
            $user->balance += $request->amount;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'deposit',
                'reason' => $request->reason,
                'status' => 'success',
                'progress' => 100,
                'meta' => [
                    'currency' => $request->currency,
                    'source' => 'admin_manual_deposit',
                    'silent_for_user' => true,
                ],
            ]);
        });

        Log::info('Admin made deposit', [
            'admin_id' => auth()->id(),
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
        ]);


        $message = __('system_messages.admin_deposit_success');

        return redirect(localized_route('admin.deposit'))
            ->with('status', $message)
            ->with('success', $message);
    }

    public function exportPdf()
    {
        $transactions = Transaction::with('user')->get();
        $pdf = Pdf::loadView('admin.exports.transactions_pdf', compact('transactions'));
        return $pdf->download('transactions.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new \App\Exports\TransactionsExport, 'transactions.xlsx');
    }

    public function resetPassword($locale, User $user)
    {
        // Generate a random password
        $newPassword = Str::random(12);

        // Update user password
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // Log the action
        Log::info('Admin reset user password', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        // Send email notification
        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, $newPassword));
        } catch (\Exception $e) {
            Log::error('Failed to send password reset email', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect(localized_route('admin.users'))->with('status', __('system_messages.admin_password_reset'));
    }

    public function createUser($locale)
    {
        $countries = config('countries');
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.users.create', array_merge(
            compact('countries', 'recentUsers'),
            $this->getAdminShellData()
        ));
    }

    private function getAdminShellData(): array
    {
        $admin = auth()->user();
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $pendingUsersCount = User::where('status', 'pending')->count();
        $suspendedUsersCount = User::where('status', 'suspended')->count();
        $totalTransactions = Transaction::count();
        $pendingTransactionsCount = Transaction::whereIn('status', ['pending', 'on_hold'])->count();
        $unreadNotificationsCount = $admin ? $admin->unreadNotifications()->count() : 0;
        $chatUnreadCount = $admin
            ? ChatMessage::where('receiver_id', $admin->id)->unread()->count()
            : 0;
        $activeUsersRate = $totalUsers > 0
            ? (int) round(($activeUsers / $totalUsers) * 100)
            : 0;

        return compact(
            'totalUsers',
            'activeUsers',
            'pendingUsersCount',
            'suspendedUsersCount',
            'totalTransactions',
            'pendingTransactionsCount',
            'unreadNotificationsCount',
            'chatUnreadCount',
            'activeUsersRate'
        );
    }

    // Helper to generate random credit card number (16 digits)
    private function generateRandomCardNumber()
    {
        $number = '';
        for ($i = 0; $i < 16; $i++) {
            $number .= mt_rand(0, 9);
        }
        return $number;
    }

    // Helper to generate random expiry date (3 years from now)
    private function generateRandomExpiryDate()
    {
        return now()->addYears(3)->format('Y-m-d');
    }

    // Helper to get random card type
    private function getRandomCardType()
    {
        $types = ['Visa', 'MasterCard', 'American Express'];
        return $types[array_rand($types)];
    }

    private function issueLoginLink(User $user): array
    {
        do {
            $rawToken = Str::random(12);
            $tokenHash = hash('sha256', $rawToken);
        } while (User::where('login_link_token', $tokenHash)->exists());

        $expiresAt = now()->addDays(config('auth.login_link_ttl_days', 90));

        $user->forceFill([
            'login_link_token' => $tokenHash,
            'login_link_expires_at' => $expiresAt,
            'login_link_used_at' => null,
        ])->save();

        $locale = $user->locale ?? app()->getLocale();
        $loginLink = route('login.short', ['locale' => $locale, 'token' => $rawToken]);

        return [$loginLink, $expiresAt];
    }

    public function storeUser(Request $request)
    {
        $this->normalizePhoneInput($request);
        $normalizedIdType = match ((string) $request->input('type_piece')) {
            'Passeport' => 'Passport',
            'passport' => 'Passport',
            default => $request->input('type_piece'),
        };
        $request->merge(['type_piece' => $normalizedIdType]);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => $this->phoneRules(),
            'role' => 'required|in:user,admin',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'pays' => 'required|string|max:255',
            'date_naissance' => 'nullable|date|before:today',
            'type_piece' => 'nullable|in:CNI,Passport,Permis',
            'numero_piece' => 'nullable|string|max:50|unique:users,id_number',
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
        ], [
            'phone.max' => __('auth.phone_international_format'),
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->adresse,
            'country' => $request->pays,
            'city' => $request->ville,
            'date_of_birth' => $request->date_naissance,
            'id_type' => $request->type_piece,
            'id_number' => $request->numero_piece,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'balance' => 0,
            'status' => 'active',
        ]);

        // Generate and assign a virtual credit card to the user
        $user->creditCard()->create([
            'card_holder_name' => $user->first_name . ' ' . $user->last_name,
            'card_number' => $this->generateRandomCardNumber(),
            'card_type' => $this->getRandomCardType(),
            'expiry_date' => $this->generateRandomExpiryDate(),
            'is_visible_to_user' => false,
        ]);

        $loginLink = null;
        $loginLinkExpiresAt = null;
        if ($user->role === 'user') {
            [$loginLink, $loginLinkExpiresAt] = $this->issueLoginLink($user);
        }

        Log::info('Admin created user with virtual credit card', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
            'card_number' => $user->creditCard->card_number,
        ]);

        $redirect = redirect(localized_route('admin.users'))
            ->with('status', __('system_messages.admin_user_created'));

        if ($loginLink) {
            $redirect->with('login_link', $loginLink)
                ->with('login_link_user', $user->email)
                ->with('login_link_expires_at', $loginLinkExpiresAt->format('d/m/Y H:i'));
        }

        return $redirect;
    }

    public function generateLoginLink($locale, User $user)
    {
        if ($user->role !== 'user') {
            return back()->withErrors(['error' => __('system_messages.admin_login_link_client_only')]);
        }

        if ($user->status !== 'active') {
            return back()->withErrors(['error' => __('system_messages.admin_login_link_active_only')]);
        }

        [$loginLink, $loginLinkExpiresAt] = $this->issueLoginLink($user);

        Log::info('Admin generated login link', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
            'expires_at' => $loginLinkExpiresAt,
        ]);

        return back()
            ->with('status', __('system_messages.admin_login_link_generated'))
            ->with('login_link', $loginLink)
            ->with('login_link_user', $user->email)
            ->with('login_link_expires_at', $loginLinkExpiresAt->format('d/m/Y H:i'));
    }

    public function editUser($locale, User $user)
    {
        $countries = config('countries');
        $user->loadMissing('creditCard')->loadCount([
            'transactions',
            'transactions as pending_transactions_count' => function ($query) {
                $query->whereIn('status', ['pending', 'on_hold']);
            },
        ]);

        return view('admin.users.edit', array_merge(
            compact('user', 'countries'),
            $this->getAdminShellData()
        ));
    }

    public function updateUser(Request $request, $locale, User $user)
    {
        // Handle French decimal format (comma) for balance
        $request->merge(['balance' => str_replace(',', '.', $request->balance)]);
        $this->normalizePhoneInput($request);

        $normalizedIdType = match ((string) $request->input('type_piece')) {
            'Passeport' => 'Passport',
            default => $request->input('type_piece'),
        };
        $request->merge(['type_piece' => $normalizedIdType]);

        $resolvedIdType = match ((string) ($request->input('type_piece') ?: $user->id_type ?: 'Passport')) {
            'passport', 'Passeport' => 'Passport',
            'CNI', 'Passport', 'Permis' => $request->input('type_piece') ?: $user->id_type ?: 'Passport',
            default => 'Passport',
        };

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => $this->phoneRules(),
            'date_naissance' => 'nullable|date|before:today',
            'role' => 'required|in:user,admin',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'type_piece' => 'nullable|in:CNI,Passport,Permis',
            'numero_piece' => 'nullable|string|max:50|unique:users,id_number,' . $user->id,
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,suspended',

            'card_holder_name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:20',
            'card_type' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date_format:Y-m-d',
            'card_visible_to_user' => 'nullable|boolean',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'phone.max' => __('auth.phone_international_format'),
        ]);

        $updateData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->adresse,
            'country' => $request->has('pays') ? $request->pays : $user->country,
            'city' => $request->has('ville') ? $request->ville : $user->city,
            'date_of_birth' => $request->has('date_naissance') ? $request->date_naissance : $user->date_of_birth,
            'id_type' => $resolvedIdType,
            'id_number' => $request->has('numero_piece') ? $request->numero_piece : $user->id_number,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'balance' => $request->balance,
            'status' => $request->status,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $updateData['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($updateData);

        // Manage credit card info
        $sanitizedCardNumber = $request->filled('card_number')
            ? preg_replace('/\s+/', '', (string) $request->input('card_number'))
            : null;
        $cardDataProvided = $request->filled('card_holder_name') || filled($sanitizedCardNumber) || $request->filled('card_type') || $request->filled('expiry_date');
        $cardPayload = [
            'card_holder_name' => $request->input('card_holder_name'),
            'card_number' => $sanitizedCardNumber,
            'card_type' => $request->input('card_type'),
            'expiry_date' => $request->input('expiry_date'),
            'is_visible_to_user' => $request->boolean('card_visible_to_user'),
        ];

        if ($cardDataProvided) {
            if ($user->creditCard) {
                // Update existing credit card
                $user->creditCard->update($cardPayload);
            } else {
                // Create new credit card
                $user->creditCard()->create($cardPayload);
            }
        } else {
            // No data provided, delete existing credit card if any
            if ($user->creditCard) {
                $user->creditCard->delete();
            }
        }

        Log::info('Admin updated user', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        return redirect(localized_route('admin.users'))->with('status', __('system_messages.admin_user_updated'));
    }

    public function deleteUser($locale, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => __('system_messages.admin_self_delete_forbidden')]);
        }

        $user->delete();

        Log::info('Admin deleted user', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        return redirect(localized_route('admin.users'))->with('status', __('system_messages.admin_user_deleted'));
    }

    public function approveUser($locale, User $user)
    {
        if ($user->status !== 'pending') {
            return back()->withErrors(['error' => __('system_messages.admin_user_not_pending')]);
        }

        $user->update(['status' => 'active']);

        // Send notification email to user about approval
        try {
            Mail::to($user->email)->queue(new UserApprovedNotification($user));
        } catch (\Exception $e) {
            Log::error('Failed to send user approval notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Notify user of account approval
        try {
            NotificationService::notifyAccountApproved($user);
        } catch (\Exception $e) {
            Log::error('Failed to notify user of approval', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        Log::info('Admin approved user', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        return back()->with('status', __('system_messages.admin_user_approved'));
    }

    /**
     * Display all transactions for admin management
     */
    public function transactions(Request $request)
    {
        $query = Transaction::with('user');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search by transaction ID or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $filteredTransactionsCount = (clone $query)->count();
        $filteredTransactionsVolume = (clone $query)->sum('amount');
        $filteredSuccessCount = (clone $query)->where('status', 'success')->count();
        $filteredReviewCount = (clone $query)->whereIn('status', ['pending', 'on_hold'])->count();
        $filteredRefundedCount = (clone $query)->where('status', 'refunded')->count();
        $transactionsTodayCount = (clone $query)->whereDate('created_at', today())->count();
        $filteredSuccessRate = $filteredTransactionsCount > 0
            ? (int) round(($filteredSuccessCount / $filteredTransactionsCount) * 100)
            : 0;
        $recentTransactions = (clone $query)->latest()->take(6)->get();

        $transactions = $query->latest()->paginate(20)->withQueryString();
        $users = User::where('role', 'user')->orderBy('first_name')->get();

        return view('admin.transactions', array_merge(
            compact(
                'transactions',
                'users',
                'filteredTransactionsCount',
                'filteredTransactionsVolume',
                'filteredSuccessCount',
                'filteredReviewCount',
                'filteredRefundedCount',
                'transactionsTodayCount',
                'filteredSuccessRate',
                'recentTransactions'
            ),
            $this->getAdminShellData()
        ));
    }

    /**
     * Refund a successful transaction
     */
    public function refundTransaction(Request $request, $locale, Transaction $transaction)
    {
        // Validate the request
        $request->validate([
            'refund_reason' => 'nullable|string|max:500',
        ]);

        // Check if transaction can be refunded
        if ($transaction->status !== 'success') {
            return back()->withErrors(['error' => __('system_messages.refund_success_only')]);
        }

        if ($transaction->status === 'refunded') {
            return back()->withErrors(['error' => __('system_messages.refund_already_done')]);
        }

        // Perform refund in a database transaction
        DB::transaction(function () use ($transaction, $request) {
            $user = $transaction->user()->lockForUpdate()->first();

            // Credit the amount back to user's balance
            $user->balance = $user->balance + $transaction->amount;
            $user->save();

            // Update transaction status
            $transaction->update([
                'status' => 'refunded',
                'refunded_at' => now(),
                'refunded_by' => auth()->id(),
                'refund_reason' => $request->refund_reason,
            ]);
        });

        // Send refund notification email to user
        try {
            Mail::to($transaction->user->email)->queue(
                new TransactionRefundedMail($transaction, $request->refund_reason)
            );
        } catch (\Exception $e) {
            Log::error('Failed to send refund notification email', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Notify user of refund
        try {
            $message = __('system_messages.refund_notification', [
                'amount' => number_format($transaction->amount, 2, ',', ' '),
            ]);
            if ($request->refund_reason) {
                $message .= ". Motif: {$request->refund_reason}";
            }

            NotificationService::notifyRefund($transaction->user, $transaction);
        } catch (\Exception $e) {
            Log::error('Failed to notify user of refund', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
            ]);
        }

        Log::info('Admin refunded transaction', [
            'admin_id' => auth()->id(),
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->user->id,
            'amount' => $transaction->amount,
            'refund_reason' => $request->refund_reason,
        ]);

        return back()->with('status', __('system_messages.refund_done', [
            'amount' => number_format($transaction->amount, 2, ',', ' '),
            'client' => $transaction->user->first_name . ' ' . $transaction->user->last_name,
        ]));
    }
    private function normalizePhoneInput(Request $request): void
    {
        $request->merge([
            'phone' => PhoneNumber::sanitize($request->input('phone')),
        ]);
    }

    private function phoneRules(): array
    {
        return [
            'nullable',
            'string',
            'max:20',
            static function (string $attribute, mixed $value, \Closure $fail): void {
                if ($value === null || $value === '') {
                    return;
                }

                if (!PhoneNumber::isValid($value)) {
                    $fail(__('auth.phone_international_format'));
                }
            },
        ];
    }
}
