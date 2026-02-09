<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Events\NotificationCreated;

class NotificationService
{
    /**
     * Créer une notification pour un utilisateur
     */
    public static function create(User $user, string $type, string $title, string $message, array $data = []): Notification
    {
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'is_read' => false,
        ]);

        event(new NotificationCreated($notification));

        return $notification;
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

    /**
     * Notification pour connexion utilisateur (vers tous les admins sauf l'utilisateur lui-même si c'est un admin)
     */
    public static function notifyAdminUserLogin(User $user, string $ipAddress, string $userAgent): void
    {
        $admins = User::where('role', 'admin')->where('id', '!=', $user->id)->get();

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'account',
                'Connexion utilisateur',
                "L'utilisateur {$user->first_name} {$user->last_name} ({$user->email}) s'est connecté depuis {$ipAddress}. Navigateur: {$userAgent}",
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'action' => 'login'
                ],
                'blue',
                'fa-sign-in-alt'
            );
        }
    }

    /**
     * Notification pour connexion utilisateur (vers l'utilisateur lui-même)
     */
    public static function notifyUserLogin(User $user, string $ipAddress, string $userAgent): void
    {
        self::create(
            $user,
            'account',
            'Connexion réussie',
            "Vous vous êtes connecté avec succès depuis {$ipAddress}.",
            [
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'action' => 'login'
            ],
            'green',
            'fa-check-circle'
        );
    }

    /**
     * Notification pour inscription utilisateur (vers tous les admins)
     */
    public static function notifyAdminUserRegistration(User $user, string $ipAddress): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'account',
                'Nouvelle inscription',
                "Nouvel utilisateur inscrit: {$user->first_name} {$user->last_name} ({$user->email}) depuis {$ipAddress}. Statut: en attente de validation.",
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'status' => $user->status,
                    'action' => 'registration'
                ],
                'purple',
                'fa-user-plus'
            );
        }
    }

    /**
     * Notification pour déconnexion utilisateur (vers tous les admins sauf l'utilisateur lui-même si c'est un admin)
     */
    public static function notifyAdminUserLogout(User $user, string $ipAddress): void
    {
        $admins = User::where('role', 'admin')->where('id', '!=', $user->id)->get();

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'account',
                'Déconnexion utilisateur',
                "L'utilisateur {$user->first_name} {$user->last_name} ({$user->email}) s'est déconnecté depuis {$ipAddress}.",
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'action' => 'logout'
                ],
                'gray',
                'fa-sign-out-alt'
            );
        }
    }

    /**
     * Notification pour virement réussi (vers tous les admins)
     */
    public static function notifyAdminTransfer(User $user, $transaction): void
    {
        $amount = \App\Helpers\CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'transaction',
                'Nouveau virement',
                "Virement effectué: {$user->first_name} {$user->last_name} ({$user->email}) a transféré {$amount} à {$transaction->recipient_name}.",
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'recipient_name' => $transaction->recipient_name,
                    'recipient_iban' => $transaction->recipient_iban,
                    'action' => 'transfer_success'
                ],
                'green',
                'fa-exchange-alt'
            );
        }
    }

    /**
     * Notification pour virement échoué (vers tous les admins)
     */
    public static function notifyAdminTransferFailed(User $user, $transaction, string $reason = null): void
    {
        $amount = \App\Helpers\CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        $admins = User::where('role', 'admin')->get();

        $message = "Échec de virement: {$user->first_name} {$user->last_name} ({$user->email}) - {$amount} à {$transaction->recipient_name}.";
        if ($reason) {
            $message .= " Raison: {$reason}";
        }

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'transaction',
                'Virement échoué',
                $message,
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'recipient_name' => $transaction->recipient_name,
                    'recipient_iban' => $transaction->recipient_iban,
                    'reason' => $reason,
                    'action' => 'transfer_failed'
                ],
                'red',
                'fa-exclamation-triangle'
            );
        }
    }

    /**
     * Notification pour dépôt admin (vers tous les admins)
     */
    public static function notifyAdminDeposit(User $user, float $amount, string $currency = 'EUR'): void
    {
        $formattedAmount = \App\Helpers\CurrencyHelper::format($amount, $currency);
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'transaction',
                'Dépôt effectué',
                "Dépôt admin: {$formattedAmount} crédité sur le compte de {$user->first_name} {$user->last_name} ({$user->email}).",
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'amount' => $amount,
                    'currency' => $currency,
                    'action' => 'deposit'
                ],
                'green',
                'fa-money-bill-wave'
            );
        }
    }

}
