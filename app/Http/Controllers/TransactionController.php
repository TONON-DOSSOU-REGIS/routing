<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function create()
    {
        return view('transactions.create');
    }

    public function start(TransferRequest $request)
    {
        $user = auth()->user();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'transfer',
            'recipient_name' => $request->recipient_name,
            'recipient_iban' => $request->recipient_iban,
            'recipient_bic' => $request->recipient_bic,
            'bank_name' => $request->bank_name,
            'reason' => $request->reason,
            'activation_code' => $request->activation_code,
            'status' => 'pending',
            'progress' => 1,
        ]);

        // Notify admins that a user initiated a transfer
        if (!$user->isAdmin()) {
            try {
                NotificationService::notifyAdminTransferStarted($user, $transaction);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to notify admins of transfer start', [
                    'transaction_id' => $transaction->id,
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json(['tx_id' => $transaction->id]);
    }

    public function progress(Request $request)
    {
        $tx = Transaction::where('id', $request->tx_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Priorité : settings spécifiques à l'utilisateur, sinon global
        $settings = Setting::where('target_user_id', auth()->id())
            ->where('is_global', false)
            ->first();

        if (!$settings) {
            $settings = Setting::where('is_global', true)->first();
        }

        // Si aucun setting n'existe, créer des valeurs par défaut
        if (!$settings) {
            $settings = new Setting([
                'stop_percentage' => 0,
                'stop_message' => '',
                'is_global' => true,
                'target_user_id' => null
            ]);
        }

        \Illuminate\Support\Facades\Log::info('Progress check', [
            'transaction_id' => $tx->id,
            'current_progress' => $tx->progress,
            'status' => $tx->status,
            'stop_percentage' => $settings->stop_percentage,
            'user_id' => auth()->id(),
        ]);

        $increment = 1; // Incrément de 10% pour une progression visible et rapide
        $p = min(100, (int)$tx->progress + $increment);

        if ($tx->status === 'pending') {
            // Check for completion FIRST (priority over stop_percentage)
            if ($p >= 100) {
                DB::transaction(function () use ($tx) {
                    $user = $tx->user()->lockForUpdate()->first();
                    $user->balance = $user->balance - $tx->amount;
                    $user->save();
                    $tx->update(['progress' => 100, 'status' => 'success']);
                });

                // Send confirmation email to user
                try {
                    \Illuminate\Support\Facades\Mail::to($tx->user->email)->send(new \App\Mail\TransferConfirmationMail($tx));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send transfer confirmation email', [
                        'transaction_id' => $tx->id,
                        'user_id' => $tx->user->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                // Notify user of successful transfer
                try {
                    NotificationService::notifyTransaction($tx->user, $tx, 'success');
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to create user notification', [
                        'transaction_id' => $tx->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                // Notify admins of successful transfer
                try {
                    NotificationService::notifyAdminTransfer($tx->user, $tx);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to notify admins of transfer', [
                        'transaction_id' => $tx->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                return response()->json(['status' => 'success', 'progress' => 100]);
            }

            // Check for stop_percentage (only if not yet at 100%)
            if ($p >= (int)$settings->stop_percentage && (int)$settings->stop_percentage > 0 && $p < 100) {
                $tx->update([
                    'progress' => $settings->stop_percentage,
                    'status'   => 'on_hold',
                    'message'  => $settings->stop_message,
                ]);

                // Notify user that transaction is on hold
                try {
                    NotificationService::notifySystem(
                        $tx->user,
                        'Transaction en attente',
                        "Votre transaction #{$tx->id} est en attente de validation."
                    );
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to create on-hold notification', [
                        'transaction_id' => $tx->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                // Notify admins that transaction is on hold
                try {
                    NotificationService::notifyAdminTransferFailed(
                        $tx->user,
                        $tx,
                        "Transaction mise en attente à {$settings->stop_percentage}%"
                    );
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to notify admins of on-hold transfer', [
                        'transaction_id' => $tx->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                return response()->json([
                    'status' => 'on_hold',
                    'progress' => (int)$settings->stop_percentage,
                    'message' => $settings->stop_message,
                ]);
            }

            $tx->update(['progress' => $p]);
            return response()->json(['status' => 'pending', 'progress' => $p]);
        }

        // Déjà on_hold ou success → renvoyer l'état courant
        return response()->json([
            'status' => $tx->status,
            'progress' => (int)$tx->progress,
            'message' => $tx->message
        ]);
    }

    public function history(Request $request)
    {
        $query = auth()->user()->transactions();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(10)->appends($request->all());

        return view('transactions.history', compact('transactions'));
    }

    public function receiptPdf($locale, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('transactions.receipt', compact('transaction'))
            ->setOption('defaultFont', 'dejavu sans');
        return $pdf->download('receipt_' . $transaction->id . '.pdf');
    }

    // New method to return HTML receipt view
    public function receiptHtml($locale, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return view('transactions.receipt', compact('transaction'));
    }
}
