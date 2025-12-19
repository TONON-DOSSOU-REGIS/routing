<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lignes de Langue des Transactions
    |--------------------------------------------------------------------------
    */

    // Titres de page
    'page_title' => 'Nouveau virement - SG BANK',
    'new_transfer' => 'Nouveau virement',

    // Navigation
    'dashboard' => 'Tableau de bord',
    'logout' => 'Déconnexion',

    // En-têtes
    'transfer_title' => 'Nouveau virement',
    'transfer_subtitle' => 'Effectuez un transfert sécurisé vers un bénéficiaire',

    // Indicateurs d'étapes
    'step_information' => 'Informations',
    'step_processing' => 'Traitement',
    'step_confirmation' => 'Confirmation',

    // Sections du formulaire
    'transfer_details' => 'Détails du virement',
    'beneficiary_info' => 'Renseignez les informations du bénéficiaire',
    'banking_details' => 'Coordonnées bancaires',
    'additional_info' => 'Informations supplémentaires',

    // Étiquettes du formulaire
    'amount' => 'Montant du virement',
    'recipient_name' => 'Nom du bénéficiaire',
    'bank_name' => 'Nom de la banque',
    'recipient_iban' => 'IBAN du bénéficiaire',
    'recipient_bic' => 'BIC du bénéficiaire',
    'reason' => 'Motif du virement (optionnel)',
    'activation_code' => 'Code d\'activation',

    // Espaces réservés
    'amount_placeholder' => '0.00',
    'recipient_name_placeholder' => 'Jean Dupont',
    'bank_name_placeholder' => 'Banque Nationale',
    'recipient_iban_placeholder' => 'FR76 1234 5678 9012 3456 7890 123',
    'recipient_bic_placeholder' => 'BNPAFRPP',
    'transfer_reason_placeholder' => 'Remboursement, cadeau...',
    'activation_code_placeholder' => 'Votre code d\'activation personnel',

    // Boutons
    'cancel' => 'Annuler',
    'start_transfer' => 'Lancer le virement',
    'processing' => 'Traitement en cours...',

    // Section de progression
    'processing_in_progress' => 'Traitement en cours',
    'transfer_progress' => 'Progression du virement',
    'processing_message' => 'Votre virement est en cours de traitement. Veuillez patienter...',

    // Messages flash
    'operation_interrupted' => 'Opération interrompue',
    'operation_successful' => 'Opération réussie',
    'transfer_successful' => 'Virement effectué avec succès ! Vous allez être redirigé...',
    'transfer_success_message' => 'Virement effectué avec succès !',
    'understood' => 'J\'ai compris',

    // Messages d'erreur
    'amount_required' => 'Le champ montant est requis.',
    'recipient_name_required' => 'Le champ nom du bénéficiaire est requis.',
    'bank_name_required' => 'Le champ nom de la banque est requis.',
    'iban_required' => 'Le champ IBAN est requis.',
    'bic_required' => 'Le champ BIC est requis.',
    'activation_code_required' => 'Le champ code d\'activation est requis.',
    'reason_required' => 'Le champ motif est requis.',

    // Messages de validation
    'invalid_amount' => 'Veuillez saisir un montant valide.',
    'invalid_iban' => 'Veuillez saisir un IBAN valide.',
    'invalid_bic' => 'Veuillez saisir un BIC valide.',
    'invalid_activation_code' => 'Veuillez saisir un code d\'activation valide.',

    // Messages de statut
    'transfer_pending' => 'Virement en attente de vérification de sécurité.',
    'connection_error' => 'Erreur de connexion lors du traitement.',

    // Page d'historique
    'history_page_title' => 'Historique des transactions - SG BANK',
    'history_title' => 'Historique des transactions',
    'history_subtitle' => 'Consultez l\'ensemble de vos opérations financières',
    'history_overview' => 'Vue d\'ensemble de vos opérations financières',
    
    // Boutons d'export
    'export_pdf' => 'Export PDF',
    'export_excel' => 'Export Excel',
    
    // Filtres
    'filter_type' => 'Type',
    'filter_status' => 'Statut',
    'filter_date_from' => 'Date de début',
    'filter_date_to' => 'Date de fin',
    'filter_apply' => 'Appliquer',
    
    // Options de filtres - Types
    'all_types' => 'Tous les types',
    'type_transfer' => 'Virement',
    'type_deposit' => 'Dépôt',
    'type_withdrawal' => 'Retrait',
    
    // Options de filtres - Statuts
    'all_statuses' => 'Tous les statuts',
    'status_pending' => 'En attente',
    'status_on_hold' => 'Suspendu',
    'status_success' => 'Réussi',
    'status_failed' => 'Échoué',
    
    // En-têtes de tableau
    'table_transaction' => 'Transaction',
    'table_type' => 'Type',
    'table_amount' => 'Montant',
    'table_recipient' => 'Bénéficiaire',
    'table_status' => 'Statut',
    'table_progress' => 'Progression',
    'table_date' => 'Date',
    'table_actions' => 'Actions',
    
    // Actions
    'action_receipt' => 'Reçu',
    'action_download_receipt' => 'Télécharger le reçu',
    
    // Messages vides
    'no_transactions' => 'Aucune transaction trouvée',
    'no_transactions_message' => 'Aucune transaction ne correspond à vos critères de recherche.',
    'reset_filters' => 'Réinitialiser les filtres',
    
    // Pagination
    'showing_results' => 'Affichage de :first à :last sur :total transactions',
    
    // JavaScript
    'generating' => 'Génération...',
];
