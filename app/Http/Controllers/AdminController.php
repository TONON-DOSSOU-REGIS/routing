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

    public function settings()
    {
        $settings = Setting::first();
        return view('admin.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'stop_percentage' => 'required|integer|min:0|max:99',
            'stop_message' => 'required|string|max:255',
            'target_user_id' => 'nullable|exists:users,id',
            'is_global' => 'required|boolean',
        ]);

        $settings = Setting::first();
        $settings->update($request->only(['stop_percentage', 'stop_message', 'target_user_id', 'is_global']));

        Log::info('Admin updated settings', [
            'admin_id' => auth()->id(),
            'stop_percentage' => $request->stop_percentage,
            'stop_message' => $request->stop_message,
            'target_user_id' => $request->target_user_id,
            'is_global' => $request->is_global,
        ]);

        return back()->with('status', 'Paramètres mis à jour avec succès.');
    }

    public function users()
    {
        $users = User::paginate(20);
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
            $user->balance += $request->amount;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'deposit',
                'reason' => $request->reason,
                'status' => 'success',
                'progress' => 100,
            ]);
        });

        Log::info('Admin made deposit', [
            'admin_id' => auth()->id(),
            'user_id' => $request->user_id,
            'amount' => $request->amount,
        ]);

        // TODO: Send notification to user

        return back()->with('status', 'Dépôt effectué avec succès.');
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
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'role' => 'required|in:user,admin',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'type_piece' => 'nullable|string|max:50',
            'numero_piece' => 'nullable|string|max:50',
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
            'date_of_birth' => $request->date_naissance,
            'role' => $request->role,
            'address' => $request->adresse,
            'city' => $request->ville,
            'country' => $request->pays,
            'id_type' => $request->type_piece,
            'id_number' => $request->numero_piece,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'activation_code' => $request->activation_code,
            'balance' => 0,
            'status' => 'active',
        ]);

        Log::info('Admin created user', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        return redirect()->route('admin.users')->with('status', 'Utilisateur créé avec succès.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
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
            'date_naissance' => 'nullable|date',
            'role' => 'required|in:user,admin',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'type_piece' => 'nullable|string|max:50',
            'numero_piece' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'activation_code' => 'nullable|string|max:255',
            'balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,suspended',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_naissance,
            'role' => $request->role,
            'address' => $request->adresse,
            'city' => $request->ville,
            'country' => $request->pays,
            'id_type' => $request->type_piece,
            'id_number' => $request->numero_piece,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'activation_code' => $request->activation_code,
            'balance' => $request->balance,
            'status' => $request->status,
        ]);

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
}
