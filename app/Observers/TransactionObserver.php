<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class TransactionObserver
{
    /**
     * Notify admins for user-initiated non-transfer transactions.
     */
    public function created(Transaction $transaction): void
    {
        $actor = auth()->user();
        if (!$actor || $actor->isAdmin()) {
            return;
        }

        if ((int) $actor->id !== (int) $transaction->user_id) {
            return;
        }

        // Transfer lifecycle already has dedicated admin notifications.
        if ($transaction->type === 'transfer') {
            return;
        }

        $user = $transaction->user;
        if (!$user || $user->isAdmin()) {
            return;
        }

        try {
            NotificationService::notifyAdminTransactionActivity($user, $transaction);
        } catch (\Throwable $e) {
            Log::error('Failed to notify admins of transaction activity', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Notify admins when a user-initiated non-transfer transaction status changes.
     */
    public function updated(Transaction $transaction): void
    {
        if (!$transaction->wasChanged('status')) {
            return;
        }

        $actor = auth()->user();
        if (!$actor || $actor->isAdmin()) {
            return;
        }

        if ((int) $actor->id !== (int) $transaction->user_id) {
            return;
        }

        if ($transaction->type === 'transfer') {
            return;
        }

        $user = $transaction->user;
        if (!$user || $user->isAdmin()) {
            return;
        }

        try {
            NotificationService::notifyAdminTransactionActivity($user, $transaction);
        } catch (\Throwable $e) {
            Log::error('Failed to notify admins of transaction status update', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'status' => $transaction->status,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

