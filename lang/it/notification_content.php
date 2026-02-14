<?php

return [
    'api' => [
        'not_found' => 'Notifica non trovata.',
        'marked_read' => 'Notifica segnata come letta.',
        'all_marked_read' => 'Tutte le notifiche sono state segnate come lette.',
        'all_read_deleted' => 'Tutte le notifiche lette sono state eliminate.',
    ],

    'transaction_types' => [
        'deposit' => 'deposito',
        'withdrawal' => 'prelievo',
        'transfer' => 'bonifico',
        'credit' => 'credito',
        'debit' => 'addebito',
        'operation' => 'operazione',
    ],

    'account_statuses' => [
        'pending' => 'in attesa',
        'active' => 'attivo',
        'suspended' => 'sospeso',
        'blocked' => 'bloccato',
    ],

    'transaction_statuses' => [
        'pending' => 'in attesa',
        'success' => 'riuscita',
        'failed' => 'fallita',
        'on_hold' => 'in sospeso',
        'refunded' => 'rimborsata',
        'processing' => 'in elaborazione',
        'cancelled' => 'annullata',
    ],

    'titles' => [
        'transaction_new' => 'Nuova transazione',
        'message_new' => 'Nuovo messaggio',
        'account_status_changed' => 'Stato conto modificato',
        'account_approved' => 'Conto approvato',
        'security_alert' => 'Avviso di sicurezza',
        'deposit_completed' => 'Deposito effettuato',
        'transaction_refunded' => 'Transazione rimborsata',
        'admin_user_login' => 'Accesso utente',
        'user_login_success' => 'Accesso riuscito',
        'admin_user_registration' => 'Nuova registrazione',
        'admin_user_logout' => 'Disconnessione utente',
        'admin_transfer_success' => 'Nuovo bonifico',
        'admin_transfer_started' => 'Bonifico avviato',
        'admin_transfer_failed' => 'Bonifico fallito',
        'admin_user_message' => 'Nuovo messaggio utente',
        'admin_transaction_activity' => 'Nuova operazione cliente',
        'admin_deposit_completed' => 'Deposito effettuato',
    ],

    'messages' => [
        'transaction_new' => 'Un :type di :amount e stato eseguito sul tuo conto.',
        'message_new' => 'Hai ricevuto un nuovo messaggio dal supporto.',
        'account_status_changed' => "Lo stato del tuo conto e passato da ':old_status' a ':new_status'.",
        'account_approved' => 'Il tuo conto e stato approvato ed e ora attivo.',
        'deposit_completed' => 'Un deposito di :amount e stato accreditato sul tuo conto.',
        'transaction_refunded' => 'La transazione #:transaction_id di importo :amount e stata rimborsata.',
        'admin_user_login' => "L'utente :user_name (:user_email) ha effettuato l'accesso da :ip_address. Browser: :user_agent.",
        'user_login_success' => 'Accesso eseguito con successo da :ip_address.',
        'admin_user_registration' => 'Nuovo utente registrato: :user_name (:user_email) da :ip_address. Stato: :status.',
        'admin_user_logout' => "L'utente :user_name (:user_email) si e disconnesso da :ip_address.",
        'admin_transfer_success' => ':user_name (:user_email) ha effettuato un bonifico di :amount a :recipient_name.',
        'admin_transfer_started' => 'Nuova richiesta: :user_name (:user_email) ha avviato un bonifico di :amount verso :recipient_name.',
        'admin_transfer_failed' => 'Bonifico fallito per :user_name (:user_email): :amount a :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Bonifico fallito per :user_name (:user_email): :amount a :recipient_name. Motivo: :reason.',
        'admin_user_message' => 'Messaggio da :user_name (:user_email): :preview',
        'admin_transaction_activity' => ':user_name (:user_email) ha eseguito un :type di :amount. Stato: :status.',
        'admin_deposit_completed' => 'Deposito admin: :amount accreditato al conto di :user_name (:user_email).',
        'attachment_preview' => 'Allegato: :name',
        'empty_message_preview' => '(nessun testo)',
    ],
];
