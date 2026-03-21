<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Helpers\CurrencyHelper;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Lang;

class NotificationService
{
    /**
     * Create a notification for a user.
     */
    public static function create(
        User $user,
        string $type,
        string $title,
        string $message,
        array $data = [],
        ?string $color = null,
        ?string $icon = null,
        ?string $actionUrl = null
    ): Notification {
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'color' => $color ?? 'blue',
            'action_url' => $actionUrl,
            'is_read' => false,
        ]);

        event(new NotificationCreated($notification));

        return $notification;
    }

    /**
     * Notify user about a new transaction.
     */
    public static function notifyTransaction(User $user, $transaction): void
    {
        $amount = CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        $type = self::transactionTypeLabel($user, $transaction->type);

        self::create(
            $user,
            'transaction',
            self::t($user, 'notification_content.titles.transaction_new'),
            self::t($user, 'notification_content.messages.transaction_new', [
                'type' => $type,
                'amount' => $amount,
            ]),
            [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'status' => $transaction->status,
            ]
        );
    }

    /**
     * Notify user about a new support message.
     */
    public static function notifyMessage(User $user, $message): void
    {
        self::create(
            $user,
            'message',
            self::t($user, 'notification_content.titles.message_new'),
            self::t($user, 'notification_content.messages.message_new'),
            [
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'content' => substr((string) $message->message, 0, 50) . (strlen((string) $message->message) > 50 ? '...' : ''),
            ]
        );
    }

    /**
     * Notify user about account status change.
     */
    public static function notifyAccountStatus(User $user, string $oldStatus, string $newStatus): void
    {
        $oldLabel = self::accountStatusLabel($user, $oldStatus);
        $newLabel = self::accountStatusLabel($user, $newStatus);

        self::create(
            $user,
            'account',
            self::t($user, 'notification_content.titles.account_status_changed'),
            self::t($user, 'notification_content.messages.account_status_changed', [
                'old_status' => $oldLabel,
                'new_status' => $newLabel,
            ]),
            [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]
        );
    }

    /**
     * Notify user when account is approved.
     */
    public static function notifyAccountApproved(User $user): void
    {
        self::create(
            $user,
            'account',
            self::t($user, 'notification_content.titles.account_approved'),
            self::t($user, 'notification_content.messages.account_approved'),
            ['status' => 'approved']
        );
    }

    /**
     * Notify user about a security alert.
     */
    public static function notifySecurityAlert(User $user, string $alertType, string $message): void
    {
        self::create(
            $user,
            'alert',
            self::t($user, 'notification_content.titles.security_alert'),
            $message,
            ['alert_type' => $alertType]
        );
    }

    /**
     * System notification.
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
     * Notify user about a completed deposit.
     */
    public static function notifyDeposit(User $user, $transaction): void
    {
        $amount = CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');

        self::create(
            $user,
            'transaction',
            self::t($user, 'notification_content.titles.deposit_completed'),
            self::t($user, 'notification_content.messages.deposit_completed', ['amount' => $amount]),
            [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => 'deposit',
            ]
        );
    }

    /**
     * Notify user about refunded transaction.
     */
    public static function notifyRefund(User $user, $transaction): void
    {
        $amount = CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');

        self::create(
            $user,
            'transaction',
            self::t($user, 'notification_content.titles.transaction_refunded'),
            self::t($user, 'notification_content.messages.transaction_refunded', [
                'transaction_id' => $transaction->id,
                'amount' => $amount,
            ]),
            [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => 'refund',
            ]
        );
    }

    /**
     * Notify admins when a user signs in (excluding same user if admin).
     */
    public static function notifyAdminUserLogin(User $user, string $ipAddress, string $userAgent): void
    {
        $admins = User::where('role', 'admin')->where('id', '!=', $user->id)->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'account',
                self::t($admin, 'notification_content.titles.admin_user_login'),
                self::t($admin, 'notification_content.messages.admin_user_login', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'action' => 'login',
                ],
                'green',
                'fa-user-check'
            );
        }
    }

    /**
     * Notify user about successful sign in.
     */
    public static function notifyUserLogin(User $user, string $ipAddress, string $userAgent): void
    {
        self::create(
            $user,
            'account',
            self::t($user, 'notification_content.titles.user_login_success'),
            self::t($user, 'notification_content.messages.user_login_success', [
                'ip_address' => $ipAddress,
            ]),
            [
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'action' => 'login',
            ],
            'green',
            'fa-check-circle'
        );
    }

    /**
     * Notify admins about user registration.
     */
    public static function notifyAdminUserRegistration(User $user, string $ipAddress): void
    {
        $admins = User::where('role', 'admin')->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            $statusLabel = self::accountStatusLabel($admin, $user->status);

            self::create(
                $admin,
                'account',
                self::t($admin, 'notification_content.titles.admin_user_registration'),
                self::t($admin, 'notification_content.messages.admin_user_registration', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'status' => $statusLabel,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'status' => $user->status,
                    'action' => 'registration',
                ],
                'purple',
                'fa-user-plus'
            );
        }
    }

    /**
     * Notify admins when user signs out (excluding same user if admin).
     */
    public static function notifyAdminUserLogout(User $user, string $ipAddress): void
    {
        $admins = User::where('role', 'admin')->where('id', '!=', $user->id)->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'account',
                self::t($admin, 'notification_content.titles.admin_user_logout'),
                self::t($admin, 'notification_content.messages.admin_user_logout', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'ip_address' => $ipAddress,
                    'action' => 'logout',
                ],
                'gray',
                'fa-sign-out-alt'
            );
        }
    }

    /**
     * Notify admins about successful transfer.
     */
    public static function notifyAdminTransfer(User $user, $transaction): void
    {
        $amount = CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        $admins = User::where('role', 'admin')->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'transaction',
                self::t($admin, 'notification_content.titles.admin_transfer_success'),
                self::t($admin, 'notification_content.messages.admin_transfer_success', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'amount' => $amount,
                    'recipient_name' => $transaction->recipient_name,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'recipient_name' => $transaction->recipient_name,
                    'recipient_iban' => $transaction->recipient_iban,
                    'action' => 'transfer_success',
                ],
                'green',
                'fa-exchange-alt'
            );
        }
    }

    /**
     * Notify admins when transfer is started.
     */
    public static function notifyAdminTransferStarted(User $user, $transaction): void
    {
        $amount = CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        $admins = User::where('role', 'admin')->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'transaction',
                self::t($admin, 'notification_content.titles.admin_transfer_started'),
                self::t($admin, 'notification_content.messages.admin_transfer_started', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'amount' => $amount,
                    'recipient_name' => $transaction->recipient_name,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'recipient_name' => $transaction->recipient_name,
                    'recipient_iban' => $transaction->recipient_iban,
                    'action' => 'transfer_started',
                ]
            );
        }
    }

    /**
     * Notify admins when transfer failed.
     */
    public static function notifyAdminTransferFailed(User $user, $transaction, string $reason = null): void
    {
        $amount = CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        $admins = User::where('role', 'admin')->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            $message = $reason
                ? self::t($admin, 'notification_content.messages.admin_transfer_failed_with_reason', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'amount' => $amount,
                    'recipient_name' => $transaction->recipient_name,
                    'reason' => $reason,
                ])
                : self::t($admin, 'notification_content.messages.admin_transfer_failed', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'amount' => $amount,
                    'recipient_name' => $transaction->recipient_name,
                ]);

            self::create(
                $admin,
                'transaction',
                self::t($admin, 'notification_content.titles.admin_transfer_failed'),
                $message,
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'recipient_name' => $transaction->recipient_name,
                    'recipient_iban' => $transaction->recipient_iban,
                    'reason' => $reason,
                    'action' => 'transfer_failed',
                ],
                'red',
                'fa-exclamation-triangle'
            );
        }
    }

    /**
     * Notify admins when a user sends a chat message.
     */
    public static function notifyAdminUserMessage(User $user, $message): void
    {
        $rawMessage = (string) ($message->message ?? '');
        $admins = User::where('role', 'admin')->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            if ($rawMessage !== '') {
                $preview = substr($rawMessage, 0, 80) . (strlen($rawMessage) > 80 ? '...' : '');
            } elseif (!empty($message->attachment_name)) {
                $preview = self::t($admin, 'notification_content.messages.attachment_preview', [
                    'name' => $message->attachment_name,
                ]);
            } else {
                $preview = self::t($admin, 'notification_content.messages.empty_message_preview');
            }

            self::create(
                $admin,
                'message',
                self::t($admin, 'notification_content.titles.admin_user_message'),
                self::t($admin, 'notification_content.messages.admin_user_message', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'preview' => $preview,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'message_id' => $message->id,
                    'action' => 'user_message',
                ]
            );
        }
    }

    /**
     * Generic admin notification for user transaction activity outside transfer lifecycle.
     */
    public static function notifyAdminTransactionActivity(User $user, $transaction): void
    {
        $amount = CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
        $statusValue = (string) ($transaction->status ?? 'pending');
        $admins = User::where('role', 'admin')->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            $typeLabel = self::transactionTypeLabel($admin, $transaction->type);
            $statusLabel = self::transactionStatusLabel($admin, $statusValue);

            self::create(
                $admin,
                'transaction',
                self::t($admin, 'notification_content.titles.admin_transaction_activity'),
                self::t($admin, 'notification_content.messages.admin_transaction_activity', [
                    'user_name' => $userName,
                    'user_email' => $user->email,
                    'type' => $typeLabel,
                    'amount' => $amount,
                    'status' => $statusLabel,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_id' => $transaction->id,
                    'type' => $transaction->type,
                    'status' => $statusValue,
                    'amount' => $transaction->amount,
                    'action' => 'transaction_activity',
                ]
            );
        }
    }

    public static function notifyAdminDeposit(User $user, float $amount, string $currency = 'EUR'): void
    {
        $formattedAmount = CurrencyHelper::format($amount, $currency);
        $admins = User::where('role', 'admin')->get();
        $userName = self::userDisplayName($user);

        foreach ($admins as $admin) {
            self::create(
                $admin,
                'transaction',
                self::t($admin, 'notification_content.titles.admin_deposit_completed'),
                self::t($admin, 'notification_content.messages.admin_deposit_completed', [
                    'amount' => $formattedAmount,
                    'user_name' => $userName,
                    'user_email' => $user->email,
                ]),
                [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'amount' => $amount,
                    'currency' => $currency,
                    'action' => 'deposit',
                ],
                'green',
                'fa-money-bill-wave'
            );
        }
    }

    private static function t(User $user, string $key, array $replace = []): string
    {
        return Lang::get($key, $replace, self::localeFor($user));
    }

    private static function localeFor(User $user): string
    {
        $locale = trim((string) ($user->locale ?? ''));

        return $locale !== '' ? $locale : config('app.locale', 'fr');
    }

    private static function transactionTypeLabel(User $user, ?string $type): string
    {
        $fallback = self::t($user, 'notification_content.transaction_types.operation');

        if (!$type) {
            return $fallback;
        }

        $key = "notification_content.transaction_types.{$type}";
        $value = self::t($user, $key);

        return $value === $key ? $type : $value;
    }

    private static function accountStatusLabel(User $user, ?string $status): string
    {
        if (!$status) {
            return '';
        }

        $key = "notification_content.account_statuses.{$status}";
        $value = self::t($user, $key);

        return $value === $key ? $status : $value;
    }

    private static function transactionStatusLabel(User $user, ?string $status): string
    {
        if (!$status) {
            return '';
        }

        $key = "notification_content.transaction_statuses.{$status}";
        $value = self::t($user, $key);

        return $value === $key ? $status : $value;
    }

    private static function userDisplayName(User $user): string
    {
        $fullName = trim(sprintf('%s %s', (string) $user->first_name, (string) $user->last_name));

        return $fullName !== '' ? $fullName : $user->email;
    }
}
