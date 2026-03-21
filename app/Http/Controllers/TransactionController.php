<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Mail\TransferConfirmationMail;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\TransactionReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function __construct(private TransactionReceiptService $transactionReceiptService)
    {
    }

    public function create()
    {
        $user = auth()->user();

        return view('transactions.create', $this->getClientShellData($user));
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
            'progress' => 0,
        ]);

        // Notify admins that a user initiated a transfer
        if (!$user->isAdmin()) {
            try {
                NotificationService::notifyAdminTransferStarted($user, $transaction);
            } catch (\Exception $e) {
                Log::error('Failed to notify admins of transfer start', [
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

        // Priorite : settings specifiques a l'utilisateur, sinon global
        $settings = Setting::where('target_user_id', auth()->id())
            ->where('is_global', false)
            ->first();

        if (!$settings) {
            $settings = Setting::where('is_global', true)->first();
        }

        // Legacy fallback if old rows do not have proper scope flags.
        if (!$settings) {
            $settings = Setting::first();
        }

        // Si aucun setting n'existe, creer des valeurs par defaut
        if (!$settings) {
            $settings = new Setting([
                'stop_percentage' => 0,
                'stop_message' => '',
                'is_global' => true,
                'target_user_id' => null,
            ]);
        }

        $stopPercentage = max(0, min(100, (int) ($settings->stop_percentage ?? 0)));
        $stopMessage = trim((string) ($settings->stop_message ?? ''));
        if ($stopMessage === '') {
            $stopMessage = __('transactions.transaction_on_hold');
        }

        Log::info('Progress check', [
            'transaction_id' => $tx->id,
            'current_progress' => $tx->progress,
            'status' => $tx->status,
            'stop_percentage' => $stopPercentage,
            'user_id' => auth()->id(),
        ]);

        $increment = $this->calculateProgressIncrement((int) $tx->progress, $stopPercentage);
        $p = min(100, (int) $tx->progress + $increment);

        if ($tx->status === 'pending') {
            // Completion has priority over stop percentage.
            if ($p === 100) {
                $justCompleted = DB::transaction(function () use ($tx) {
                    $lockedTx = Transaction::whereKey($tx->id)->lockForUpdate()->firstOrFail();

                    if ($lockedTx->status !== 'pending') {
                        return false;
                    }

                    $user = $lockedTx->user()->lockForUpdate()->first();
                    $user->balance = $user->balance - $lockedTx->amount;
                    $user->save();

                    $lockedTx->update([
                        'progress' => 100,
                        'status' => 'success',
                    ]);

                    return true;
                });

                $tx->refresh();
                $tx->loadMissing('user');

                // Send email automatically once when transfer reaches exactly 100%.
                $this->sendTransferCompletionEmailOnce($tx);

                if ($justCompleted) {
                    // Notify user of successful transfer
                    try {
                        NotificationService::notifyTransaction($tx->user, $tx);
                    } catch (\Exception $e) {
                        Log::error('Failed to create user notification', [
                            'transaction_id' => $tx->id,
                            'error' => $e->getMessage(),
                        ]);
                    }

                    // Notify admins of successful transfer
                    try {
                        NotificationService::notifyAdminTransfer($tx->user, $tx);
                    } catch (\Exception $e) {
                        Log::error('Failed to notify admins of transfer', [
                            'transaction_id' => $tx->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }

                return response()->json([
                    'status' => $tx->status,
                    'progress' => (int) $tx->progress,
                    'message' => $tx->message,
                ]);
            }

            // Check for stop_percentage (only if not yet at 100%)
            if ($stopPercentage > 0 && $stopPercentage < 100 && $p >= $stopPercentage) {
                $tx->update([
                    'progress' => $stopPercentage,
                    'status' => 'on_hold',
                    'message' => $stopMessage,
                ]);

                // Notify user that transaction is on hold
                try {
                    NotificationService::notifySystem(
                        $tx->user,
                        'Transaction en attente',
                        "Votre transaction #{$tx->id} est en attente de validation."
                    );
                } catch (\Exception $e) {
                    Log::error('Failed to create on-hold notification', [
                        'transaction_id' => $tx->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                // Notify admins that transaction is on hold
                try {
                    NotificationService::notifyAdminTransferFailed(
                        $tx->user,
                        $tx,
                        "Transaction mise en attente a {$stopPercentage}%"
                    );
                } catch (\Exception $e) {
                    Log::error('Failed to notify admins of on-hold transfer', [
                        'transaction_id' => $tx->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                return response()->json([
                    'status' => 'on_hold',
                    'progress' => $stopPercentage,
                    'message' => $stopMessage,
                    'recipient_name' => $tx->recipient_name,
                    'recipient_iban' => $tx->recipient_iban,
                    'recipient_bic' => $tx->recipient_bic,
                    'bank_name' => $tx->bank_name,
                ]);
            }

            $tx->update(['progress' => $p]);

            return response()->json(['status' => 'pending', 'progress' => $p]);
        }

        if ($tx->status === 'success' && (int) $tx->progress === 100) {
            $tx->loadMissing('user');
            $this->sendTransferCompletionEmailOnce($tx);
        }

        return response()->json([
            'status' => $tx->status,
            'progress' => (int) $tx->progress,
            'message' => $tx->message,
            'recipient_name' => $tx->recipient_name,
            'recipient_iban' => $tx->recipient_iban,
            'recipient_bic' => $tx->recipient_bic,
            'bank_name' => $tx->bank_name,
        ]);
    }

    private function calculateProgressIncrement(int $currentProgress, int $stopPercentage): int
    {
        $targetProgress = $stopPercentage > 0 && $stopPercentage < 100
            ? $stopPercentage
            : 100;

        $remaining = max(0, $targetProgress - $currentProgress);

        return $remaining > 0 ? 1 : 0;
    }

    private function sendTransferCompletionEmailOnce(Transaction $transaction): void
    {
        if ($transaction->type !== 'transfer' || $transaction->status !== 'success' || (int) $transaction->progress !== 100) {
            return;
        }

        $transactionId = $transaction->id;

        $shouldSend = DB::transaction(function () use ($transactionId) {
            $lockedTx = Transaction::whereKey($transactionId)->lockForUpdate()->first();

            if (!$lockedTx || $lockedTx->type !== 'transfer' || $lockedTx->status !== 'success' || (int) $lockedTx->progress !== 100) {
                return false;
            }

            $meta = is_array($lockedTx->meta) ? $lockedTx->meta : [];
            if (($meta['transfer_completion_email_sent'] ?? false) === true) {
                return false;
            }

            $meta['transfer_completion_email_sent'] = true;
            $meta['transfer_completion_email_sent_at'] = now()->toDateTimeString();

            $lockedTx->meta = $meta;
            $lockedTx->save();

            return true;
        });

        if (!$shouldSend) {
            return;
        }

        $mailTransaction = Transaction::with('user')->find($transactionId);
        if (!$mailTransaction || !$mailTransaction->user) {
            return;
        }

        try {
            Mail::to($mailTransaction->user->email)->send(new TransferConfirmationMail($mailTransaction));
        } catch (\Throwable $e) {
            Log::error('Failed to send transfer confirmation email', [
                'transaction_id' => $transactionId,
                'user_id' => $mailTransaction->user->id,
                'error' => $e->getMessage(),
            ]);

            // Allow retry on future calls if mail sending fails.
            DB::transaction(function () use ($transactionId) {
                $lockedTx = Transaction::whereKey($transactionId)->lockForUpdate()->first();

                if (!$lockedTx) {
                    return;
                }

                $meta = is_array($lockedTx->meta) ? $lockedTx->meta : [];
                $meta['transfer_completion_email_sent'] = false;
                unset($meta['transfer_completion_email_sent_at']);

                $lockedTx->meta = $meta;
                $lockedTx->save();
            });
        }
    }

    public function history(Request $request)
    {
        $user = auth()->user();
        $query = $user->transactions()->with('user');

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

        $summaryQuery = clone $query;
        $transactions = $query->latest()->paginate(10)->appends($request->all());
        $historySummary = [
            'total' => (clone $summaryQuery)->count(),
            'success' => (clone $summaryQuery)->where('status', 'success')->count(),
            'pending' => (clone $summaryQuery)->whereIn('status', ['pending', 'on_hold'])->count(),
            'volume' => (float) ((clone $summaryQuery)->sum('amount') ?? 0),
        ];

        return view('transactions.history', array_merge(
            [
                'transactions' => $transactions,
                'historySummary' => $historySummary,
            ],
            $this->getClientShellData($user)
        ));
    }

    private function getClientShellData(User $user): array
    {
        $unreadNotificationsCount = $user->unreadNotifications()->count();
        $pendingOperationsCount = $user->transactions()
            ->whereIn('status', ['pending', 'on_hold'])
            ->count();

        $profileFields = [
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->phone,
            $user->address,
            $user->country,
            $user->city,
            $user->date_of_birth,
            $user->id_type,
            $user->id_number,
            $user->iban,
            $user->profile_photo_path,
        ];

        $profileCompletion = (int) round(
            (collect($profileFields)->filter(fn ($value) => filled($value))->count() / count($profileFields)) * 100
        );

        return compact(
            'user',
            'unreadNotificationsCount',
            'pendingOperationsCount',
            'profileCompletion'
        );
    }

    public function receiptPdf($locale, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->loadMissing(['user', 'refundedBy']);

        try {
            return response($this->transactionReceiptService->renderPdf($transaction), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $this->transactionReceiptService->makeFilename($transaction) . '"',
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Receipt PDF fallback to HTML', [
                'transaction_id' => $transaction->id,
                'user_id' => auth()->id(),
                'gd_loaded' => extension_loaded('gd'),
                'error' => $exception->getMessage(),
            ]);

            $reason = extension_loaded('gd')
                ? 'Le PDF premium est temporairement indisponible. La version HTML securisee est affichee a la place.'
                : 'Le serveur ne dispose pas de l extension GD requise pour certains rendus PDF. La version HTML securisee est affichee a la place.';

            return response()->view('transactions.receipt', $this->transactionReceiptService->buildViewData($transaction, 'html', $reason));
        }
    }

    // New method to return HTML receipt view
    public function receiptHtml($locale, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->loadMissing(['user', 'refundedBy']);

        return view('transactions.receipt', $this->transactionReceiptService->buildViewData($transaction, 'html'));
    }
}
