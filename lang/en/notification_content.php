<?php

return [
    'api' => [
        'not_found' => 'Notification not found.',
        'marked_read' => 'Notification marked as read.',
        'all_marked_read' => 'All notifications marked as read.',
        'all_read_deleted' => 'All read notifications deleted.',
    ],

    'transaction_types' => [
        'deposit' => 'deposit',
        'withdrawal' => 'withdrawal',
        'transfer' => 'transfer',
        'credit' => 'credit',
        'debit' => 'debit',
        'operation' => 'operation',
    ],

    'account_statuses' => [
        'pending' => 'pending',
        'active' => 'active',
        'suspended' => 'suspended',
        'blocked' => 'blocked',
    ],

    'transaction_statuses' => [
        'pending' => 'pending',
        'success' => 'successful',
        'failed' => 'failed',
        'on_hold' => 'on hold',
        'refunded' => 'refunded',
        'processing' => 'processing',
        'cancelled' => 'cancelled',
    ],

    'titles' => [
        'transaction_new' => 'New transaction',
        'message_new' => 'New message',
        'account_status_changed' => 'Account status changed',
        'account_approved' => 'Account approved',
        'security_alert' => 'Security alert',
        'deposit_completed' => 'Deposit completed',
        'transaction_refunded' => 'Transaction refunded',
        'admin_user_login' => 'User login',
        'user_login_success' => 'Successful login',
        'admin_user_registration' => 'New registration',
        'admin_user_logout' => 'User logout',
        'admin_transfer_success' => 'New transfer',
        'admin_transfer_started' => 'Transfer started',
        'admin_transfer_failed' => 'Transfer failed',
        'admin_user_message' => 'New user message',
        'admin_transaction_activity' => 'New client operation',
        'admin_deposit_completed' => 'Deposit completed',
    ],

    'messages' => [
        'transaction_new' => 'A :type of :amount has been processed on your account.',
        'message_new' => 'You received a new support message.',
        'account_status_changed' => "Your account status changed from ':old_status' to ':new_status'.",
        'account_approved' => 'Congratulations! Your account has been approved and is now active.',
        'deposit_completed' => 'A deposit of :amount was credited to your account.',
        'transaction_refunded' => 'Transaction #:transaction_id with amount :amount has been refunded.',
        'admin_user_login' => 'User :user_name (:user_email) signed in from :ip_address. Browser: :user_agent.',
        'user_login_success' => 'You signed in successfully from :ip_address.',
        'admin_user_registration' => 'New user registration: :user_name (:user_email) from :ip_address. Status: :status.',
        'admin_user_logout' => 'User :user_name (:user_email) signed out from :ip_address.',
        'admin_transfer_success' => ':user_name (:user_email) completed a transfer of :amount to :recipient_name.',
        'admin_transfer_started' => 'New transfer request: :user_name (:user_email) started a transfer of :amount to :recipient_name.',
        'admin_transfer_failed' => 'Transfer failed for :user_name (:user_email): :amount to :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Transfer failed for :user_name (:user_email): :amount to :recipient_name. Reason: :reason.',
        'admin_user_message' => 'Message from :user_name (:user_email): :preview',
        'admin_transaction_activity' => ':user_name (:user_email) performed a :type of :amount. Status: :status.',
        'admin_deposit_completed' => 'Admin deposit: :amount credited to :user_name (:user_email).',
        'attachment_preview' => 'Attachment: :name',
        'empty_message_preview' => '(no text)',
    ],
];
