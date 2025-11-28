<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Mail\PasswordResetMail;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\UserRegistrationNotification;
use App\Mail\UserApprovedNotification;
use App\Mail\TransactionRefundedMail;
use App\Services\NotificationService;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');
        $totalTransfers = Transaction::where('type', 'transfer')->sum('amount');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransactions',
            'totalDeposits',
            'totalWithdrawals',
            'totalTransfers'
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

    public function settings()
    {
        $settings = Setting::first();
        return view('admin.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'stop_percentage' => 'required|integer|between:0,100',
            'stop_message' => 'required|string|max:255',
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

        return back()->with('status', 'Paramètres mis à jour avec succès.');
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
        
        return view('admin.users', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $user->update(['status' => $user->status === 'active' ? 'suspended' : 'active']);

        Log::info('Admin toggled user status', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'new_status' => $user->status,
        ]);

        return back()->with('status', 'Statut utilisateur mis à jour.');
    }

    public function depositForm()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.deposit', compact('users'));
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
                'meta' => ['currency' => $request->currency],
            ]);
        });

        Log::info('Admin made deposit', [
            'admin_id' => auth()->id(),
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
        ]);

        // Notify user of deposit
        try {
            $user = User::findOrFail($request->user_id);
            $transaction = Transaction::where('user_id', $user->id)
                                     ->where('type', 'deposit')
                                     ->latest()
                                     ->first();
            
            if ($transaction) {
                NotificationService::notifyTransaction($user, $transaction, 'success');
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify user of deposit', [
                'user_id' => $request->user_id,
                'error' => $e->getMessage(),
            ]);
        }

        // Notify all admins of deposit
        try {
            $user = User::findOrFail($request->user_id);
            NotificationService::notifyAdminDeposit($user, $request->amount, $request->currency);
        } catch (\Exception $e) {
            Log::error('Failed to notify admins of deposit', [
                'user_id' => $request->user_id,
                'error' => $e->getMessage(),
            ]);
        }

        // Notify the admin who performed the deposit with a confirmation
        try {
            $user = User::findOrFail($request->user_id);
            $currentAdmin = auth()->user();
            NotificationService::notifyAdminDepositConfirmation($currentAdmin, $user, $request->amount, $request->currency);
        } catch (\Exception $e) {
            Log::error('Failed to notify admin of deposit confirmation', [
                'admin_id' => auth()->id(),
                'user_id' => $request->user_id,
                'error' => $e->getMessage(),
            ]);
        }

        return back()->with('status', 'Dépôt effectué avec succès. La devise par défaut de l\'utilisateur a été mise à jour.');
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

    public function resetPassword(User $user)
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

        return redirect()->route('admin.users')->with('status', 'Mot de passe réinitialisé avec succès. Un email a été envoyé à l\'utilisateur.');
    }

    public function createUser()
    {
        $countries = config('countries');
        return view('admin.users.create', compact('countries'));
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

    public function storeUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
            'adresse' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'activation_code' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->adresse,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'activation_code' => $request->activation_code,
            'balance' => 0,
            'status' => 'active',
        ]);

        // Generate and assign a virtual credit card to the user
        $user->creditCard()->create([
            'card_holder_name' => $user->first_name . ' ' . $user->last_name,
            'card_number' => $this->generateRandomCardNumber(),
            'card_type' => $this->getRandomCardType(),
            'expiry_date' => $this->generateRandomExpiryDate(),
        ]);

        Log::info('Admin created user with virtual credit card', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
            'card_number' => $user->creditCard->card_number,
        ]);

        return redirect()->route('admin.users')->with('status', 'Utilisateur créé avec succès et carte de crédit virtuelle générée.');
    }

    public function editUser(User $user)
    {
        $countries = config('countries');
        return view('admin.users.edit', compact('user', 'countries'));
    }

    public function updateUser(Request $request, User $user)
    {
        // Handle French decimal format (comma) for balance
        $request->merge(['balance' => str_replace(',', '.', $request->balance)]);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
            'adresse' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'activation_code' => 'nullable|string|max:255',
            'balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,suspended',

            'card_holder_name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:20',
            'card_type' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date_format:Y-m-d',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->adresse,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'activation_code' => $request->activation_code,
            'balance' => $request->balance,
            'status' => $request->status,
        ]);

        // Manage credit card info
        $cardDataProvided = $request->filled('card_holder_name') || $request->filled('card_number') || $request->filled('card_type') || $request->filled('expiry_date');

        if ($cardDataProvided) {
            if ($user->creditCard) {
                // Update existing credit card
                $user->creditCard->update([
                    'card_holder_name' => $request->input('card_holder_name'),
                    'card_number' => $request->input('card_number'),
                    'card_type' => $request->input('card_type'),
                    'expiry_date' => $request->input('expiry_date'),
                ]);
            } else {
                // Create new credit card
                $user->creditCard()->create([
                    'card_holder_name' => $request->input('card_holder_name'),
                    'card_number' => $request->input('card_number'),
                    'card_type' => $request->input('card_type'),
                    'expiry_date' => $request->input('expiry_date'),
                ]);
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

        return redirect()->route('admin.users')->with('status', 'Utilisateur mis à jour avec succès.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $user->delete();

        Log::info('Admin deleted user', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        return redirect()->route('admin.users')->with('status', 'Utilisateur supprimé avec succès.');
    }

    public function approveUser(User $user)
    {
        if ($user->status !== 'pending') {
            return back()->withErrors(['error' => 'L\'utilisateur n\'est pas en attente de validation.']);
        }

        $user->update(['status' => 'active']);

        // Send notification email to user about approval
        try {
            Mail::to($user->email)->send(new UserApprovedNotification($user));
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

        return back()->with('status', 'Utilisateur validé avec succès. Un email de confirmation a été envoyé.');
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

        $transactions = $query->latest()->paginate(20);
        $users = User::where('role', 'user')->orderBy('first_name')->get();

        return view('admin.transactions', compact('transactions', 'users'));
    }

    /**
     * Refund a successful transaction
     */
    public function refundTransaction(Request $request, Transaction $transaction)
    {
        // Validate the request
        $request->validate([
            'refund_reason' => 'nullable|string|max:500',
        ]);

        // Check if transaction can be refunded
        if ($transaction->status !== 'success') {
            return back()->withErrors(['error' => 'Seules les transactions réussies peuvent être remboursées.']);
        }

        if ($transaction->status === 'refunded') {
            return back()->withErrors(['error' => 'Cette transaction a déjà été remboursée.']);
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
            Mail::to($transaction->user->email)->send(
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
            $message = "Votre virement de " . number_format($transaction->amount, 2, ',', ' ') . " € a été remboursé";
            if ($request->refund_reason) {
                $message .= ". Motif: {$request->refund_reason}";
            }
            
            NotificationService::notifySystem(
                $transaction->user,
                '💰 Remboursement effectué',
                $message,
                'green'
            );
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

        return back()->with('status', 'Remboursement effectué avec succès ! Le montant de ' . number_format($transaction->amount, 2, ',', ' ') . ' € a été recrédité sur le compte du client ' . $transaction->user->first_name . ' ' . $transaction->user->last_name . '.');
    }
}

