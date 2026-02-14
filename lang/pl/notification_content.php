<?php

return [
    'api' => [
        'not_found' => 'Powiadomienie nie znalezione.',
        'marked_read' => 'Powiadomienie oznaczone jako przeczytane.',
        'all_marked_read' => 'Wszystkie powiadomienia oznaczone jako przeczytane.',
        'all_read_deleted' => 'Wszystkie przeczytane powiadomienia usuniete.',
    ],

    'transaction_types' => [
        'deposit' => 'wplata',
        'withdrawal' => 'wyplata',
        'transfer' => 'przelew',
        'credit' => 'kredyt',
        'debit' => 'debet',
        'operation' => 'operacja',
    ],

    'account_statuses' => [
        'pending' => 'oczekujacy',
        'active' => 'aktywny',
        'suspended' => 'zawieszony',
        'blocked' => 'zablokowany',
    ],

    'transaction_statuses' => [
        'pending' => 'oczekujaca',
        'success' => 'zakonczona',
        'failed' => 'nieudana',
        'on_hold' => 'wstrzymana',
        'refunded' => 'zwrcona',
        'processing' => 'przetwarzana',
        'cancelled' => 'anulowana',
    ],

    'titles' => [
        'transaction_new' => 'Nowa transakcja',
        'message_new' => 'Nowa wiadomosc',
        'account_status_changed' => 'Zmiana statusu konta',
        'account_approved' => 'Konto zatwierdzone',
        'security_alert' => 'Alert bezpieczenstwa',
        'deposit_completed' => 'Wplata wykonana',
        'transaction_refunded' => 'Transakcja zwrocona',
        'admin_user_login' => 'Logowanie uzytkownika',
        'user_login_success' => 'Logowanie udane',
        'admin_user_registration' => 'Nowa rejestracja',
        'admin_user_logout' => 'Wylogowanie uzytkownika',
        'admin_transfer_success' => 'Nowy przelew',
        'admin_transfer_started' => 'Przelew rozpoczety',
        'admin_transfer_failed' => 'Przelew nieudany',
        'admin_user_message' => 'Nowa wiadomosc uzytkownika',
        'admin_transaction_activity' => 'Nowa operacja klienta',
        'admin_deposit_completed' => 'Wplata wykonana',
    ],

    'messages' => [
        'transaction_new' => 'Na Twoim koncie wykonano :type na kwote :amount.',
        'message_new' => 'Otrzymales nowa wiadomosc od wsparcia.',
        'account_status_changed' => "Status Twojego konta zmienil sie z ':old_status' na ':new_status'.",
        'account_approved' => 'Twoje konto zostalo zatwierdzone i jest teraz aktywne.',
        'deposit_completed' => 'Wplata :amount zostala zaksiwowana na Twoim koncie.',
        'transaction_refunded' => 'Transakcja #:transaction_id na kwote :amount zostala zwrocona.',
        'admin_user_login' => 'Uzytkownik :user_name (:user_email) zalogowal sie z :ip_address. Przegladarka: :user_agent.',
        'user_login_success' => 'Zalogowales sie pomyslnie z :ip_address.',
        'admin_user_registration' => 'Nowa rejestracja: :user_name (:user_email) z :ip_address. Status: :status.',
        'admin_user_logout' => 'Uzytkownik :user_name (:user_email) wylogowal sie z :ip_address.',
        'admin_transfer_success' => ':user_name (:user_email) wykonal przelew :amount do :recipient_name.',
        'admin_transfer_started' => 'Nowe zlecenie: :user_name (:user_email) rozpoczal przelew :amount do :recipient_name.',
        'admin_transfer_failed' => 'Przelew nieudany dla :user_name (:user_email): :amount do :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Przelew nieudany dla :user_name (:user_email): :amount do :recipient_name. Powod: :reason.',
        'admin_user_message' => 'Wiadomosc od :user_name (:user_email): :preview',
        'admin_transaction_activity' => ':user_name (:user_email) wykonal :type na kwote :amount. Status: :status.',
        'admin_deposit_completed' => 'Wplata admina: :amount zaksiwowana na koncie :user_name (:user_email).',
        'attachment_preview' => 'Zalacznik: :name',
        'empty_message_preview' => '(brak tresci)',
    ],
];
