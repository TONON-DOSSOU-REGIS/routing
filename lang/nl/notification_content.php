<?php

return [
    'api' => [
        'not_found' => 'Melding niet gevonden.',
        'marked_read' => 'Melding als gelezen gemarkeerd.',
        'all_marked_read' => 'Alle meldingen als gelezen gemarkeerd.',
        'all_read_deleted' => 'Alle gelezen meldingen verwijderd.',
    ],

    'transaction_types' => [
        'deposit' => 'storting',
        'withdrawal' => 'opname',
        'transfer' => 'overschrijving',
        'credit' => 'credit',
        'debit' => 'debet',
        'operation' => 'operatie',
    ],

    'account_statuses' => [
        'pending' => 'in afwachting',
        'active' => 'actief',
        'suspended' => 'geschorst',
        'blocked' => 'geblokkeerd',
    ],

    'transaction_statuses' => [
        'pending' => 'in afwachting',
        'success' => 'geslaagd',
        'failed' => 'mislukt',
        'on_hold' => 'in behandeling',
        'refunded' => 'terugbetaald',
        'processing' => 'verwerken',
        'cancelled' => 'geannuleerd',
    ],

    'titles' => [
        'transaction_new' => 'Nieuwe transactie',
        'message_new' => 'Nieuw bericht',
        'account_status_changed' => 'Accountstatus gewijzigd',
        'account_approved' => 'Account goedgekeurd',
        'security_alert' => 'Beveiligingsmelding',
        'deposit_completed' => 'Storting uitgevoerd',
        'transaction_refunded' => 'Transactie terugbetaald',
        'admin_user_login' => 'Aanmelding klantomgeving',
        'user_login_success' => 'Succesvolle login',
        'admin_user_registration' => 'Nieuwe registratie',
        'admin_user_logout' => 'Gebruiker uitgelogd',
        'admin_transfer_success' => 'Nieuwe overschrijving',
        'admin_transfer_started' => 'Overschrijving gestart',
        'admin_transfer_failed' => 'Overschrijving mislukt',
        'admin_user_message' => 'Nieuw gebruikersbericht',
        'admin_transaction_activity' => 'Nieuwe klantoperatie',
        'admin_deposit_completed' => 'Storting uitgevoerd',
    ],

    'messages' => [
        'transaction_new' => 'Een :type van :amount is uitgevoerd op uw account.',
        'message_new' => 'U heeft een nieuw bericht van support ontvangen.',
        'account_status_changed' => "Uw accountstatus is gewijzigd van ':old_status' naar ':new_status'.",
        'account_approved' => 'Uw account is goedgekeurd en nu actief.',
        'deposit_completed' => 'Een storting van :amount is op uw account bijgeschreven.',
        'transaction_refunded' => 'Transactie #:transaction_id met bedrag :amount is terugbetaald.',
        'admin_user_login' => 'Klant :user_name (:user_email) heeft zojuist ingelogd op de klantomgeving. IP-adres: :ip_address. Gedetecteerde browser: :user_agent.',
        'user_login_success' => 'U bent succesvol ingelogd vanaf :ip_address.',
        'admin_user_registration' => 'Nieuwe gebruiker geregistreerd: :user_name (:user_email) vanaf :ip_address. Status: :status.',
        'admin_user_logout' => 'Gebruiker :user_name (:user_email) logde uit vanaf :ip_address.',
        'admin_transfer_success' => ':user_name (:user_email) voerde een overschrijving uit van :amount naar :recipient_name.',
        'admin_transfer_started' => 'Nieuwe aanvraag: :user_name (:user_email) startte een overschrijving van :amount naar :recipient_name.',
        'admin_transfer_failed' => 'Overschrijving mislukt voor :user_name (:user_email): :amount naar :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Overschrijving mislukt voor :user_name (:user_email): :amount naar :recipient_name. Reden: :reason.',
        'admin_user_message' => 'Bericht van :user_name (:user_email): :preview',
        'admin_transaction_activity' => ':user_name (:user_email) voerde een :type uit van :amount. Status: :status.',
        'admin_deposit_completed' => 'Admin storting: :amount bijgeschreven op account van :user_name (:user_email).',
        'attachment_preview' => 'Bijlage: :name',
        'empty_message_preview' => '(geen tekst)',
    ],
];
