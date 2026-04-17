<?php

return [
    'api' => [
        'not_found' => 'Notification introuvable.',
        'marked_read' => 'Notification marquée comme lue.',
        'all_marked_read' => 'Toutes les notifications ont été marquées comme lues.',
        'all_read_deleted' => 'Toutes les notifications lues ont été supprimées.',
    ],

    'transaction_types' => [
        'deposit' => 'dépôt',
        'withdrawal' => 'retrait',
        'transfer' => 'virement',
        'credit' => 'crédit',
        'debit' => 'débit',
        'operation' => 'opération',
    ],

    'account_statuses' => [
        'pending' => 'en attente',
        'active' => 'actif',
        'suspended' => 'suspendu',
        'blocked' => 'bloqué',
    ],

    'transaction_statuses' => [
        'pending' => 'en attente',
        'success' => 'réussie',
        'failed' => 'échouée',
        'on_hold' => 'en attente',
        'refunded' => 'remboursée',
        'processing' => 'en cours',
        'cancelled' => 'annulée',
    ],

    'titles' => [
        'transaction_new' => 'Nouvelle transaction',
        'message_new' => 'Nouveau message',
        'account_status_changed' => 'Changement de statut',
        'account_approved' => 'Compte approuvé',
        'security_alert' => 'Alerte de sécurité',
        'deposit_completed' => 'Dépôt effectué',
        'transaction_refunded' => 'Transaction remboursée',
        'admin_user_login' => 'Connexion à l\'interface client',
        'user_login_success' => 'Connexion réussie',
        'admin_user_registration' => 'Nouvelle inscription',
        'admin_user_logout' => 'Déconnexion utilisateur',
        'admin_transfer_success' => 'Nouveau virement',
        'admin_transfer_started' => 'Virement initié',
        'admin_transfer_failed' => 'Virement échoué',
        'admin_user_message' => 'Nouveau message utilisateur',
        'admin_transaction_activity' => 'Nouvelle opération client',
        'admin_deposit_completed' => 'Dépôt effectué',
    ],

    'messages' => [
        'transaction_new' => 'Une opération de type :type, d\'un montant de :amount, a été effectuée sur votre compte.',
        'message_new' => 'Vous avez reçu un nouveau message du support.',
        'account_status_changed' => 'Le statut de votre compte est passé de ":old_status" à ":new_status".',
        'account_approved' => 'Félicitations ! Votre compte a été approuvé et est maintenant actif.',
        'deposit_completed' => 'Un dépôt de :amount a été crédité sur votre compte.',
        'transaction_refunded' => 'La transaction #:transaction_id, d\'un montant de :amount, a été remboursée.',
        'admin_user_login' => 'Le client :user_name (:user_email) vient de se connecter à son interface. Adresse IP : :ip_address. Navigateur détecté : :user_agent.',
        'user_login_success' => 'Vous vous êtes connecté avec succès depuis :ip_address.',
        'admin_user_registration' => 'Nouvel utilisateur inscrit : :user_name (:user_email) depuis :ip_address. Statut : :status.',
        'admin_user_logout' => 'L\'utilisateur :user_name (:user_email) s\'est déconnecté depuis :ip_address.',
        'admin_transfer_success' => 'Virement effectué : :user_name (:user_email) a transféré :amount à :recipient_name.',
        'admin_transfer_started' => 'Nouvelle demande : :user_name (:user_email) a initié un virement de :amount vers :recipient_name.',
        'admin_transfer_failed' => 'Échec du virement : :user_name (:user_email) - :amount à :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Échec du virement : :user_name (:user_email) - :amount à :recipient_name. Raison : :reason.',
        'admin_user_message' => 'Message de :user_name (:user_email) : :preview',
        'admin_transaction_activity' => 'Opération utilisateur : :user_name (:user_email) a effectué un :type de :amount. Statut : :status.',
        'admin_deposit_completed' => 'Dépôt administrateur : :amount crédité sur le compte de :user_name (:user_email).',
        'attachment_preview' => 'Pièce jointe : :name',
        'empty_message_preview' => '(aucun texte)',
    ],
];
