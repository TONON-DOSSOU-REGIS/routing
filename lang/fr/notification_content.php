<?php

return [
    'api' => [
        'not_found' => 'Notification introuvable.',
        'marked_read' => 'Notification marquee comme lue.',
        'all_marked_read' => 'Toutes les notifications ont ete marquees comme lues.',
        'all_read_deleted' => 'Toutes les notifications lues ont ete supprimees.',
    ],

    'transaction_types' => [
        'deposit' => 'depot',
        'withdrawal' => 'retrait',
        'transfer' => 'virement',
        'credit' => 'credit',
        'debit' => 'debit',
        'operation' => 'operation',
    ],

    'account_statuses' => [
        'pending' => 'en attente',
        'active' => 'actif',
        'suspended' => 'suspendu',
        'blocked' => 'bloque',
    ],

    'transaction_statuses' => [
        'pending' => 'en attente',
        'success' => 'reussie',
        'failed' => 'echouee',
        'on_hold' => 'en attente',
        'refunded' => 'remboursee',
        'processing' => 'en cours',
        'cancelled' => 'annulee',
    ],

    'titles' => [
        'transaction_new' => 'Nouvelle transaction',
        'message_new' => 'Nouveau message',
        'account_status_changed' => 'Changement de statut',
        'account_approved' => 'Compte approuve',
        'security_alert' => 'Alerte de securite',
        'deposit_completed' => 'Depot effectue',
        'transaction_refunded' => 'Transaction remboursee',
        'admin_user_login' => 'Connexion interface client',
        'user_login_success' => 'Connexion reussie',
        'admin_user_registration' => 'Nouvelle inscription',
        'admin_user_logout' => 'Deconnexion utilisateur',
        'admin_transfer_success' => 'Nouveau virement',
        'admin_transfer_started' => 'Virement initie',
        'admin_transfer_failed' => 'Virement echoue',
        'admin_user_message' => 'Nouveau message utilisateur',
        'admin_transaction_activity' => 'Nouvelle operation client',
        'admin_deposit_completed' => 'Depot effectue',
    ],

    'messages' => [
        'transaction_new' => 'Un :type de :amount a ete effectue sur votre compte.',
        'message_new' => 'Vous avez recu un nouveau message du support.',
        'account_status_changed' => "Le statut de votre compte est passe de ':old_status' a ':new_status'.",
        'account_approved' => 'Felicitations ! Votre compte a ete approuve et est maintenant actif.',
        'deposit_completed' => 'Un depot de :amount a ete credite sur votre compte.',
        'transaction_refunded' => "La transaction #:transaction_id d'un montant de :amount a ete remboursee.",
        'admin_user_login' => "Le client :user_name (:user_email) vient de se connecter a son interface. Adresse IP : :ip_address. Navigateur detecte : :user_agent.",
        'user_login_success' => 'Vous vous etes connecte avec succes depuis :ip_address.',
        'admin_user_registration' => 'Nouvel utilisateur inscrit: :user_name (:user_email) depuis :ip_address. Statut: :status.',
        'admin_user_logout' => "L'utilisateur :user_name (:user_email) s'est deconnecte depuis :ip_address.",
        'admin_transfer_success' => 'Virement effectue: :user_name (:user_email) a transfere :amount a :recipient_name.',
        'admin_transfer_started' => 'Nouvelle demande: :user_name (:user_email) a initie un virement de :amount vers :recipient_name.',
        'admin_transfer_failed' => 'Echec de virement: :user_name (:user_email) - :amount a :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Echec de virement: :user_name (:user_email) - :amount a :recipient_name. Raison: :reason.',
        'admin_user_message' => 'Message de :user_name (:user_email) : :preview',
        'admin_transaction_activity' => 'Operation utilisateur: :user_name (:user_email) a effectue un :type de :amount. Statut: :status.',
        'admin_deposit_completed' => 'Depot admin: :amount credite sur le compte de :user_name (:user_email).',
        'attachment_preview' => 'Piece jointe: :name',
        'empty_message_preview' => '(aucun texte)',
    ],
];
