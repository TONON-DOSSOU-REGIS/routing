<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Zeilen der Sprachdatei für Transaktionen
    |--------------------------------------------------------------------------
    */

    // Seitentitel
    'page_title' => 'Neue Überweisung - SG BANK',
    'new_transfer' => 'Neue Überweisung',

    // Navigation
    'dashboard' => 'Dashboard',
    'logout' => 'Abmelden',

    // Überschriften
    'transfer_title' => 'Neue Überweisung',
    'transfer_subtitle' => 'Führen Sie eine sichere Überweisung an einen Begünstigten durch',

    // Schritt-Indikatoren
    'step_information' => 'Informationen',
    'step_processing' => 'Verarbeitung',
    'step_confirmation' => 'Bestätigung',

    // Formularabschnitte
    'transfer_details' => 'Überweisungsdetails',
    'beneficiary_info' => 'Begünstigteninformationen eingeben',
    'banking_details' => 'Bankdaten',
    'additional_info' => 'Zusätzliche Informationen',

    // Formularbeschriftungen
    'amount' => 'Überweisungsbetrag',
    'recipient_name' => 'Name des Begünstigten',
    'bank_name' => 'Name der Bank',
    'recipient_iban' => 'IBAN des Begünstigten',
    'recipient_bic' => 'BIC des Begünstigten',
    'reason' => 'Überweisungsgrund (optional)',
    'activation_code' => 'Aktivierungscode',

    // Platzhalter
    'amount_placeholder' => '0.00',
    'recipient_name_placeholder' => 'Max Mustermann',
    'bank_name_placeholder' => 'Deutsche Bank',
    'iban_placeholder' => 'DE89 3704 0044 0532 0130 00',
    'bic_placeholder' => 'COBADEFFXXX',
    'reason_placeholder' => 'Rückerstattung, Geschenk...',
    'activation_code_placeholder' => 'Ihr persönlicher Aktivierungscode',

    // Schaltflächen
    'cancel' => 'Abbrechen',
    'start_transfer' => 'Überweisung starten',
    'processing' => 'Verarbeitung...',

    // Fortschrittsabschnitt
    'processing_in_progress' => 'Verarbeitung läuft',
    'transfer_progress' => 'Überweisungsfortschritt',
    'processing_message' => 'Ihre Überweisung wird verarbeitet. Bitte warten...',

    // Flash-Nachrichten
    'operation_interrupted' => 'Vorgang unterbrochen',
    'operation_successful' => 'Vorgang erfolgreich',
    'transfer_successful' => 'Überweisung erfolgreich durchgeführt. Sie werden weitergeleitet...',
    'understood' => 'Verstanden',

    // Fehlermeldungen
    'amount_required' => 'Das Betragsfeld ist erforderlich.',
    'recipient_name_required' => 'Das Feld Name des Begünstigten ist erforderlich.',
    'bank_name_required' => 'Das Feld Bankname ist erforderlich.',
    'iban_required' => 'Das IBAN-Feld ist erforderlich.',
    'bic_required' => 'Das BIC-Feld ist erforderlich.',
    'activation_code_required' => 'Das Feld Aktivierungscode ist erforderlich.',
    'reason_required' => 'Das Feld Grund ist erforderlich.',

    // Validierungsnachrichten
    'invalid_amount' => 'Bitte geben Sie einen gültigen Betrag ein.',
    'invalid_iban' => 'Bitte geben Sie eine gültige IBAN ein.',
    'invalid_bic' => 'Bitte geben Sie einen gültigen BIC ein.',
    'invalid_activation_code' => 'Bitte geben Sie einen gültigen Aktivierungscode ein.',

    // Statusnachrichten
    'transfer_pending' => 'Überweisung wartet auf Sicherheitsüberprüfung.',
    'connection_error' => 'Verbindungsfehler während der Verarbeitung.',

    // Zusätzliche Formularschlüssel
    'transfer_amount' => 'Überweisungsbetrag',
    'recipient_iban_placeholder' => 'DE89 3704 0044 0532 0130 00',
    'recipient_bic_placeholder' => 'COBADEFFXXX',
    'transfer_reason' => 'Überweisungsgrund',
    'transfer_reason_placeholder' => 'Rückerstattung, Geschenk...',
    'activation_code_placeholder' => 'Ihr persönlicher Aktivierungscode',

    // JavaScript-Nachrichten
    'error_starting_transfer' => 'Fehler beim Starten der Überweisung.',
    'connection_error_processing' => 'Verbindungsfehler während der Verarbeitung.',
    'transaction_on_hold' => 'Transaktion in Wartestellung.',
    'transfer_success_message' => 'Überweisung erfolgreich abgeschlossen!',
    'operation_success' => 'Vorgang erfolgreich',

    // Fortschrittsbeschriftungen
    'progress_label' => 'Fortschritt',

    // History page translations
    'history_page_title' => 'Transaktionsverlauf - SG BANK',
    'history_title' => 'Transaktionsverlauf',
    'history_subtitle' => 'Alle Ihre finanziellen Operationen anzeigen',
    'history_overview' => 'Übersicht Ihrer finanziellen Operationen',

    // Export buttons
    'export_pdf' => 'PDF exportieren',
    'export_excel' => 'Excel exportieren',

    // Filters
    'filter_type' => 'Typ',
    'filter_status' => 'Status',
    'filter_date_from' => 'Startdatum',
    'filter_date_to' => 'Enddatum',
    'filter_apply' => 'Anwenden',

    // Filter options - Types
    'all_types' => 'Alle Typen',
    'type_transfer' => 'Überweisung',
    'type_deposit' => 'Einzahlung',
    'type_withdrawal' => 'Auszahlung',

    // Filter options - Statuses
    'all_statuses' => 'Alle Status',
    'status_pending' => 'Ausstehend',
    'status_on_hold' => 'In Wartestellung',
    'status_success' => 'Erfolgreich',
    'status_failed' => 'Fehlgeschlagen',

    // Table headers
    'table_transaction' => 'Transaktion',
    'table_type' => 'Typ',
    'table_amount' => 'Betrag',
    'table_recipient' => 'Empfänger',
    'table_status' => 'Status',
    'table_progress' => 'Fortschritt',
    'table_date' => 'Datum',
    'table_actions' => 'Aktionen',

    // Actions
    'action_receipt' => 'Beleg',
    'action_download_receipt' => 'Beleg herunterladen',

    // Empty state messages
    'no_transactions' => 'Keine Transaktionen gefunden',
    'no_transactions_message' => 'Keine Transaktionen entsprechen Ihren Suchkriterien.',
    'reset_filters' => 'Filter zurücksetzen',

    // Pagination
    'showing_results' => ':first bis :last von :total Transaktionen anzeigen',

    // JavaScript
    'generating' => 'Generierung...',
];
