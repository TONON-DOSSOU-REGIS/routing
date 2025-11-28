<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Helpers\CurrencyHelper;

class NotificationService
{
    /**
     * Create a transaction notification
     */
    public static function notifyTransaction(User $user, $transaction, $type = 'success')
    {
        $titles = [
            'deposit' => '💰 Dépôt reçu',
            'withdrawal' => '💸 Retrait effectué',
            'transfer' => '📤 Virement envoyé',
        ];

        $messages = [
            'deposit' => "Vous avez reçu un dépôt de " . CurrencyHelper::formatForUser($user, $transaction->amount),
            'withdrawal' => "Un retrait de " . CurrencyHelper::formatForUser($user, $transaction->amount) . " a été effectué",
            'transfer' => "Votre virement de " . CurrencyHelper::formatForUser($user, $transaction->amount) . " a été envoyé",
        ];

        $colors = [
            'deposit' => 'green',
            'withdrawal' => 'red',
            'transfer' => 'blue',
        ];

        return Notification::create([
            'user_id' => $user->id,
            'type' => 'transaction',
            'title' => $titles[$transaction->type] ?? 'Transaction',
            'message' => $messages[$transaction->type] ?? "Transaction de " . CurrencyHelper::formatForUser($user, $transaction->amount),
            'icon' => 'fa-exchange-alt',
            'color' => $colors[$transaction->type] ?? 'blue',
            'action_url' => route('transactions.receipt.html', $transaction->id),
        ]);
    }

    /**
     * Create a message notification
     */
    public static function notifyNewMessage(User $user, $message)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'message',
            'title' => '💬 Nouveau message',
            'message' => 'Vous avez reçu un nouveau message du support',
            'icon' => 'fa-envelope',
            'color' => 'blue',
            'action_url' => '/dashboard',
        ]);
    }

    /**
     * Create an account validation notification
     */
    public static function notifyAccountApproved(User $user)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'account',
            'title' => '✅ Compte validé',
            'message' => 'Félicitations! Votre compte a été validé par notre équipe. Vous pouvez maintenant accéder à tous nos services.',
            'icon' => 'fa-check-circle',
            'color' => 'green',
            'action_url' => '/dashboard',
        ]);
    }

    /**
     * Create an account suspended notification
     */
    public static function notifyAccountSuspended(User $user, $reason = null)
    {
        $message = 'Votre compte a été suspendu.';
        if ($reason) {
            $message .= ' Raison: ' . $reason;
        }
        $message .= ' Veuillez contacter le support.';

        return Notification::create([
            'user_id' => $user->id,
            'type' => 'alert',
            'title' => '⚠️ Compte suspendu',
            'message' => $message,
            'icon' => 'fa-exclamation-triangle',
            'color' => 'red',
            'action_url' => route('support.nous-contacter'),
        ]);
    }

    /**
     * Create a low balance alert
     */
    public static function notifyLowBalance(User $user, $threshold = 100)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'alert',
            'title' => '⚠️ Solde faible',
            'message' => "Votre solde est inférieur à " . CurrencyHelper::formatForUser($user, $threshold) . ". Pensez à recharger votre compte.",
            'icon' => 'fa-exclamation-circle',
            'color' => 'yellow',
            'action_url' => '/dashboard',
        ]);
    }

    /**
     * Create a transaction on hold notification
     */
    public static function notifyTransactionOnHold(User $user, $transaction)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'alert',
            'title' => '⏳ Transaction en attente',
            'message' => "Votre transaction de " . CurrencyHelper::formatForUser($user, $transaction->amount) . " est en attente de validation.",
            'icon' => 'fa-clock',
            'color' => 'yellow',
            'action_url' => route('transactions.receipt.html', $transaction->id),
        ]);
    }

    /**
     * Create a password changed notification
     */
    public static function notifyPasswordChanged(User $user)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'account',
            'title' => '🔐 Mot de passe modifié',
            'message' => 'Votre mot de passe a été modifié avec succès. Si ce n\'était pas vous, contactez immédiatement le support.',
            'icon' => 'fa-key',
            'color' => 'purple',
            'action_url' => route('support.nous-contacter'),
        ]);
    }

    /**
     * Create a new login notification
     */
    public static function notifyNewLogin(User $user, $ipAddress, $userAgent)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'account',
            'title' => '🔓 Nouvelle connexion',
            'message' => "Nouvelle connexion détectée depuis {$ipAddress}",
            'icon' => 'fa-sign-in-alt',
            'color' => 'blue',
            'action_url' => '/dashboard',
        ]);
    }

    /**
     * Create a system notification
     */
    public static function notifySystem(User $user, $title, $message, $color = 'blue')
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-info-circle',
            'color' => $color,
            'action_url' => null,
        ]);
    }

    /**
     * Create a welcome notification for new users
     */
    public static function notifyWelcome(User $user)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => 'system',
            'title' => '🎉 Bienvenue sur SG BANK!',
            'message' => 'Merci de nous avoir rejoint! Découvrez toutes nos fonctionnalités et profitez d\'une expérience bancaire moderne.',
            'icon' => 'fa-hand-wave',
            'color' => 'purple',
            'action_url' => '/dashboard',
        ]);
    }

    /**
     * Notify all admins
     */
    public static function notifyAdmins($title, $message, $color = 'blue', $actionUrl = null)
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'system',
                'title' => $title,
                'message' => $message,
                'icon' => 'fa-user-shield',
                'color' => $color,
                'action_url' => $actionUrl,
            ]);
        }
    }

    /**
     * Notify admins when a user logs in
     */
    public static function notifyAdminUserLogin(User $user, $ipAddress, $userAgent = null)
    {
        $admins = User::where('role', 'admin')->get();
        
        $browser = 'Navigateur inconnu';
        if ($userAgent) {
            // Simple browser detection
            if (stripos($userAgent, 'Chrome') !== false) {
                $browser = 'Chrome';
            } elseif (stripos($userAgent, 'Firefox') !== false) {
                $browser = 'Firefox';
            } elseif (stripos($userAgent, 'Safari') !== false) {
                $browser = 'Safari';
            } elseif (stripos($userAgent, 'Edge') !== false) {
                $browser = 'Edge';
            }
        }

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'account',
                'title' => '🔓 Connexion utilisateur',
                'message' => "{$user->first_name} {$user->last_name} s'est connecté depuis {$ipAddress} ({$browser})",
                'icon' => 'fa-sign-in-alt',
                'color' => 'blue',
                'action_url' => route('admin.users'),
            ]);
        }
    }

    /**
     * Notify admins when a new user registers
     */
    public static function notifyAdminUserRegistration(User $user, $ipAddress)
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'account',
                'title' => '👤 Nouvelle inscription',
                'message' => "{$user->first_name} {$user->last_name} ({$user->email}) s'est inscrit depuis {$ipAddress}. Le compte est en attente de validation.",
                'icon' => 'fa-user-plus',
                'color' => 'purple',
                'action_url' => route('admin.users'),
            ]);
        }
    }

    /**
     * Notify admins when a deposit is made
     */
    public static function notifyAdminDeposit(User $user, $amount, $currency = 'EUR')
    {
        $admins = User::where('role', 'admin')->get();
        
        $currencySymbol = $currency === 'EUR' ? '€' : $currency;
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'transaction',
                'title' => '💰 Dépôt effectué',
                'message' => "Dépôt de " . number_format($amount, 2, ',', ' ') . " {$currencySymbol} effectué sur le compte de {$user->first_name} {$user->last_name}",
                'icon' => 'fa-money-bill-wave',
                'color' => 'green',
                'action_url' => route('admin.transactions'),
            ]);
        }
    }

    /**
     * Notify user of their own login
     */
    public static function notifyUserLogin(User $user, $ipAddress, $userAgent = null)
    {
        $browser = 'Navigateur inconnu';
        if ($userAgent) {
            // Simple browser detection
            if (stripos($userAgent, 'Chrome') !== false) {
                $browser = 'Chrome';
            } elseif (stripos($userAgent, 'Firefox') !== false) {
                $browser = 'Firefox';
            } elseif (stripos($userAgent, 'Safari') !== false) {
                $browser = 'Safari';
            } elseif (stripos($userAgent, 'Edge') !== false) {
                $browser = 'Edge';
            }
        }

        return Notification::create([
            'user_id' => $user->id,
            'type' => 'account',
            'title' => '🔓 Connexion réussie',
            'message' => "Vous vous êtes connecté depuis {$ipAddress} ({$browser}) le " . now()->format('d/m/Y à H:i'),
            'icon' => 'fa-sign-in-alt',
            'color' => 'blue',
            'action_url' => '/dashboard',
        ]);
    }

    /**
     * Notify admin who performed the deposit action
     */
    public static function notifyAdminDepositConfirmation(User $admin, User $targetUser, $amount, $currency = 'EUR')
    {
        $currencySymbol = $currency === 'EUR' ? '€' : $currency;
        
        return Notification::create([
            'user_id' => $admin->id,
            'type' => 'transaction',
            'title' => '✅ Dépôt confirmé',
            'message' => "Vous avez effectué un dépôt de " . number_format($amount, 2, ',', ' ') . " {$currencySymbol} sur le compte de {$targetUser->first_name} {$targetUser->last_name}",
            'icon' => 'fa-check-circle',
            'color' => 'green',
            'action_url' => route('admin.transactions'),
        ]);
    }
}

