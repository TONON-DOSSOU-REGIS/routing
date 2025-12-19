<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Créer une notification pour un utilisateur
     */
    public static function create(User $user, string $type, string $title, string $message, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'is_read' => false,
        ]);
    }

    /**
     * Notification pour nouvelle transaction
     */
    public static function notifyTransaction(User $user, $transaction): void
    {
        $amount = \App\Helpers\CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        
        // Déterminer le type de transaction
        $typeLabels = [
            'deposit' => 'dépôt',
            'withdrawal' => 'retrait',
            'transfer' => 'virement',
            'credit' => 'crédit',
            'debit' => 'débit'
        ];
        
        $type = $typeLabels[$transaction->type] ?? $transaction->type;

        self::create(
            $user,
            'transaction',
            'Nouvelle transaction',
            "Un {$type} de {$amount} a été effectué sur votre compte.",
            [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'status' => $transaction->status
            ]
        );
    }

    /**
     * Notification pour nouveau message dans le chat
     */
    public static function notifyMessage(User $user, $message): void
    {
        self::create(
            $user,
            'message',
            'Nouveau message',
            "Vous avez reçu un nouveau message du support.",
            [
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'content' => substr($message->message, 0, 50) . (strlen($message->message) > 50 ? '...' : '')
            ]
        );
    }

    /**
     * Notification pour changement de statut de compte
     */
    public static function notifyAccountStatus(User $user, string $oldStatus, string $newStatus): void
    {
        $statusLabels = [
            'pending' => 'en attente',
            'active' => 'actif',
            'suspended' => 'suspendu',
            'blocked' => 'bloqué'
        ];

        $oldLabel = $statusLabels[$oldStatus] ?? $oldStatus;
        $newLabel = $statusLabels[$newStatus] ?? $newStatus;

        self::create(
            $user,
            'account',
            'Changement de statut',
            "Le statut de votre compte est passé de '{$oldLabel}' à '{$newLabel}'.",
            [
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]
        );
    }

    /**
     * Notification pour compte approuvé par l'admin
     */
    public static function notifyAccountApproved(User $user): void
    {
        self::create(
            $user,
            'account',
            'Compte approuvé',
            "Félicitations ! Votre compte a été approuvé et est maintenant actif.",
            ['status' => 'approved']
        );
    }

    /**
     * Notification pour alerte de sécurité
     */
    public static function notifySecurityAlert(User $user, string $alertType, string $message): void
    {
        self::create(
            $user,
            'alert',
            'Alerte de sécurité',
            $message,
            ['alert_type' => $alertType]
        );
    }

    /**
     * Notification système
     */
    public static function notifySystem(User $user, string $title, string $message): void
    {
        self::create(
            $user,
            'system',
            $title,
            $message,
            ['system' => true]
        );
    }

    /**
     * Notification pour dépôt effectué par l'admin
     */
    public static function notifyDeposit(User $user, $transaction): void
    {
        $amount = \App\Helpers\CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');

        self::create(
            $user,
            'transaction',
            'Dépôt effectué',
            "Un dépôt de {$amount} a été crédité sur votre compte.",
            [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => 'deposit'
            ]
        );
    }

    /**
     * Notification pour remboursement de transaction
     */
    public static function notifyRefund(User $user, $transaction): void
    {
        $amount = \App\Helpers\CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');

        self::create(
            $user,
            'transaction',
            'Transaction remboursée',
            "La transaction #{$transaction->id} d'un montant de {$amount} a été remboursée.",
            [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => 'refund'
            ]
        );
    }
}
