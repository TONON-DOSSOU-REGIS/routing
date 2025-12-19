<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Righe di Lingua delle Transazioni
    |--------------------------------------------------------------------------
    */

    // Titoli di pagina
    'page_title' => 'Nuovo bonifico - SG BANK',
    'new_transfer' => 'Nuovo bonifico',

    // Navigazione
    'dashboard' => 'Pannello di controllo',
    'logout' => 'Disconnetti',

    // Intestazioni
    'transfer_title' => 'Nuovo bonifico',
    'transfer_subtitle' => 'Effettua un trasferimento sicuro verso un beneficiario',

    // Indicatori di passaggio
    'step_information' => 'Informazioni',
    'step_processing' => 'Elaborazione',
    'step_confirmation' => 'Conferma',

    // Sezioni del modulo
    'transfer_details' => 'Dettagli del bonifico',
    'beneficiary_info' => 'Inserisci le informazioni del beneficiario',
    'banking_details' => 'Coordinate bancarie',
    'additional_info' => 'Informazioni aggiuntive',

    // Etichette del modulo
    'amount' => 'Importo del bonifico',
    'recipient_name' => 'Nome del beneficiario',
    'bank_name' => 'Nome della banca',
    'recipient_iban' => 'IBAN del beneficiario',
    'recipient_bic' => 'BIC del beneficiario',
    'reason' => 'Motivo del bonifico (opzionale)',
    'activation_code' => 'Codice di attivazione',

    // Segnaposti
    'amount_placeholder' => '0.00',
    'recipient_name_placeholder' => 'Mario Rossi',
    'bank_name_placeholder' => 'Banca Nazionale',
    'iban_placeholder' => 'IT60 X054 2811 1010 0000 0123 456',
    'bic_placeholder' => 'UNCRITMMXXX',
    'reason_placeholder' => 'Rimborso, regalo...',
    'activation_code_placeholder' => 'Il tuo codice di attivazione personale',

    // Pulsanti
    'cancel' => 'Annulla',
    'start_transfer' => 'Avvia bonifico',
    'processing' => 'Elaborazione in corso...',

    // Sezione di progresso
    'processing_in_progress' => 'Elaborazione in corso',
    'transfer_progress' => 'Progresso del bonifico',
    'processing_message' => 'Il tuo bonifico è in elaborazione. Attendere prego...',

    // Messaggi flash
    'operation_interrupted' => 'Operazione interrotta',
    'operation_successful' => 'Operazione riuscita',
    'transfer_successful' => 'Bonifico effettuato con successo! Verrai reindirizzato...',
    'understood' => 'Capito',

    // Messaggi di errore
    'amount_required' => 'Il campo importo è obbligatorio.',
    'recipient_name_required' => 'Il campo nome del beneficiario è obbligatorio.',
    'bank_name_required' => 'Il campo nome della banca è obbligatorio.',
    'iban_required' => 'Il campo IBAN è obbligatorio.',
    'bic_required' => 'Il campo BIC è obbligatorio.',
    'activation_code_required' => 'Il campo codice di attivazione è obbligatorio.',
    'reason_required' => 'Il campo motivo è obbligatorio.',

    // Messaggi di validazione
    'invalid_amount' => 'Inserisci un importo valido.',
    'invalid_iban' => 'Inserisci un IBAN valido.',
    'invalid_bic' => 'Inserisci un BIC valido.',
    'invalid_activation_code' => 'Inserisci un codice di attivazione valido.',

    // Messaggi di stato
    'transfer_pending' => 'Bonifico in attesa di verifica di sicurezza.',
    'connection_error' => 'Errore di connessione durante l\'elaborazione.',

    // History page translations
    'history_page_title' => 'Storico Transazioni - SG BANK',
    'history_title' => 'Storico Transazioni',
    'history_subtitle' => 'Visualizza tutte le tue operazioni finanziarie',
    'history_overview' => 'Panoramica delle tue operazioni finanziarie',

    // Export buttons
    'export_pdf' => 'Esporta PDF',
    'export_excel' => 'Esporta Excel',

    // Filters
    'filter_type' => 'Tipo',
    'filter_status' => 'Stato',
    'filter_date_from' => 'Data di inizio',
    'filter_date_to' => 'Data di fine',
    'filter_apply' => 'Applica',

    // Filter options - Types
    'all_types' => 'Tutti i tipi',
    'type_transfer' => 'Bonifico',
    'type_deposit' => 'Deposito',
    'type_withdrawal' => 'Prelievo',

    // Filter options - Statuses
    'all_statuses' => 'Tutti gli stati',
    'status_pending' => 'In attesa',
    'status_on_hold' => 'In sospeso',
    'status_success' => 'Riuscito',
    'status_failed' => 'Fallito',

    // Table headers
    'table_transaction' => 'Transazione',
    'table_type' => 'Tipo',
    'table_amount' => 'Importo',
    'table_recipient' => 'Destinatario',
    'table_status' => 'Stato',
    'table_progress' => 'Progresso',
    'table_date' => 'Data',
    'table_actions' => 'Azioni',

    // Actions
    'action_receipt' => 'Ricevuta',
    'action_download_receipt' => 'Scarica ricevuta',

    // Empty state messages
    'no_transactions' => 'Nessuna transazione trovata',
    'no_transactions_message' => 'Nessuna transazione corrisponde ai tuoi criteri di ricerca.',
    'reset_filters' => 'Ripristina filtri',

    // Pagination
    'showing_results' => 'Mostrando :first a :last di :total transazioni',

    // JavaScript
    'generating' => 'Generazione...',
];
