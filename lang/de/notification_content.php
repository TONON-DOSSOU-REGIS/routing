<?php

return [
    'api' => [
        'not_found' => 'Benachrichtigung nicht gefunden.',
        'marked_read' => 'Benachrichtigung als gelesen markiert.',
        'all_marked_read' => 'Alle Benachrichtigungen als gelesen markiert.',
        'all_read_deleted' => 'Alle gelesenen Benachrichtigungen geloescht.',
    ],

    'transaction_types' => [
        'deposit' => 'Einzahlung',
        'withdrawal' => 'Auszahlung',
        'transfer' => 'Ueberweisung',
        'credit' => 'Gutschrift',
        'debit' => 'Belastung',
        'operation' => 'Vorgang',
    ],

    'account_statuses' => [
        'pending' => 'ausstehend',
        'active' => 'aktiv',
        'suspended' => 'gesperrt',
        'blocked' => 'blockiert',
    ],

    'transaction_statuses' => [
        'pending' => 'ausstehend',
        'success' => 'erfolgreich',
        'failed' => 'fehlgeschlagen',
        'on_hold' => 'wartend',
        'refunded' => 'erstattet',
        'processing' => 'in bearbeitung',
        'cancelled' => 'storniert',
    ],

    'titles' => [
        'transaction_new' => 'Neue Transaktion',
        'message_new' => 'Neue Nachricht',
        'account_status_changed' => 'Kontostatus geaendert',
        'account_approved' => 'Konto bestaetigt',
        'security_alert' => 'Sicherheitswarnung',
        'deposit_completed' => 'Einzahlung verbucht',
        'transaction_refunded' => 'Transaktion erstattet',
        'admin_user_login' => 'Benutzer Login',
        'user_login_success' => 'Login erfolgreich',
        'admin_user_registration' => 'Neue Registrierung',
        'admin_user_logout' => 'Benutzer Logout',
        'admin_transfer_success' => 'Neue Ueberweisung',
        'admin_transfer_started' => 'Ueberweisung gestartet',
        'admin_transfer_failed' => 'Ueberweisung fehlgeschlagen',
        'admin_user_message' => 'Neue Benutzernachricht',
        'admin_transaction_activity' => 'Neue Kundenaktion',
        'admin_deposit_completed' => 'Einzahlung verbucht',
    ],

    'messages' => [
        'transaction_new' => 'Eine :type von :amount wurde auf Ihrem Konto ausgefuehrt.',
        'message_new' => 'Sie haben eine neue Support Nachricht erhalten.',
        'account_status_changed' => "Ihr Kontostatus wurde von ':old_status' auf ':new_status' geaendert.",
        'account_approved' => 'Ihr Konto wurde bestaetigt und ist jetzt aktiv.',
        'deposit_completed' => 'Eine Einzahlung von :amount wurde Ihrem Konto gutgeschrieben.',
        'transaction_refunded' => 'Transaktion #:transaction_id mit Betrag :amount wurde erstattet.',
        'admin_user_login' => 'Benutzer :user_name (:user_email) hat sich von :ip_address angemeldet. Browser: :user_agent.',
        'user_login_success' => 'Sie haben sich erfolgreich von :ip_address angemeldet.',
        'admin_user_registration' => 'Neue Registrierung: :user_name (:user_email) von :ip_address. Status: :status.',
        'admin_user_logout' => 'Benutzer :user_name (:user_email) hat sich von :ip_address abgemeldet.',
        'admin_transfer_success' => ':user_name (:user_email) hat :amount an :recipient_name ueberwiesen.',
        'admin_transfer_started' => 'Neue Ueberweisungsanfrage: :user_name (:user_email) startete :amount an :recipient_name.',
        'admin_transfer_failed' => 'Ueberweisung fehlgeschlagen fuer :user_name (:user_email): :amount an :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Ueberweisung fehlgeschlagen fuer :user_name (:user_email): :amount an :recipient_name. Grund: :reason.',
        'admin_user_message' => 'Nachricht von :user_name (:user_email): :preview',
        'admin_transaction_activity' => ':user_name (:user_email) fuehrte eine :type von :amount aus. Status: :status.',
        'admin_deposit_completed' => 'Admin Einzahlung: :amount dem Konto von :user_name (:user_email) gutgeschrieben.',
        'attachment_preview' => 'Anhang: :name',
        'empty_message_preview' => '(kein text)',
    ],
];
