<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Transactie Taalregels
    |--------------------------------------------------------------------------
    */

    // Paginatitels
    'page_title' => 'Nieuwe overschrijving - SG BANK',
    'new_transfer' => 'Nieuwe overschrijving',

    // Navigatie
    'dashboard' => 'Dashboard',
    'logout' => 'Uitloggen',

    // Koppen
    'transfer_title' => 'Nieuwe overschrijving',
    'transfer_subtitle' => 'Voer een veilige overschrijving uit naar een begunstigde',

    // Stapindicatoren
    'step_information' => 'Informatie',
    'step_processing' => 'Verwerking',
    'step_confirmation' => 'Bevestiging',

    // Formuliersecties
    'transfer_details' => 'Overschrijvingsdetails',
    'beneficiary_info' => 'Voer begunstigdeninformatie in',
    'banking_details' => 'Bankgegevens',
    'additional_info' => 'Aanvullende informatie',

    // Formulierlabels
    'amount' => 'Overschrijvingsbedrag',
    'recipient_name' => 'Naam begunstigde',
    'bank_name' => 'Naam bank',
    'recipient_iban' => 'IBAN begunstigde',
    'recipient_bic' => 'BIC begunstigde',
    'reason' => 'Reden overschrijving (optioneel)',
    'activation_code' => 'Activeringscode',

    // Plaatsaanduidingen
    'amount_placeholder' => '0.00',
    'recipient_name_placeholder' => 'Jan Jansen',
    'bank_name_placeholder' => 'Nationale Bank',
    'iban_placeholder' => 'NL91 ABNA 0417 1643 00',
    'bic_placeholder' => 'ABNANL2A',
    'reason_placeholder' => 'Terugbetaling, cadeau...',
    'activation_code_placeholder' => 'Uw persoonlijke activeringscode',

    // Knoppen
    'cancel' => 'Annuleren',
    'start_transfer' => 'Overschrijving starten',
    'processing' => 'Verwerking bezig...',

    // Voortgangssectie
    'processing_in_progress' => 'Verwerking bezig',
    'transfer_progress' => 'Overschrijvingsvoortgang',
    'processing_message' => 'Uw overschrijving wordt verwerkt. Even geduld...',

    // Flitsberichten
    'operation_interrupted' => 'Bewerking onderbroken',
    'operation_successful' => 'Bewerking geslaagd',
    'transfer_successful' => 'Overschrijving succesvol uitgevoerd! U wordt doorgestuurd...',
    'transfer_success_message' => 'Overschrijving succesvol uitgevoerd!',
    'understood' => 'Begrepen',

    // Foutmeldingen
    'amount_required' => 'Het bedrag veld is verplicht.',
    'recipient_name_required' => 'Het veld naam begunstigde is verplicht.',
    'bank_name_required' => 'Het veld banknaam is verplicht.',
    'iban_required' => 'Het IBAN veld is verplicht.',
    'bic_required' => 'Het BIC veld is verplicht.',
    'activation_code_required' => 'Het veld activeringscode is verplicht.',
    'reason_required' => 'Het veld reden is verplicht.',

    // Validatieberichten
    'invalid_amount' => 'Voer een geldig bedrag in.',
    'invalid_iban' => 'Voer een geldige IBAN in.',
    'invalid_bic' => 'Voer een geldige BIC in.',
    'invalid_activation_code' => 'Voer een geldige activeringscode in.',

    // Statusberichten
    'transfer_pending' => 'Overschrijving wacht op beveiligingscontrole.',
    'connection_error' => 'Verbindingsfout tijdens verwerking.',

    // Geschiedenispagina
    'history_page_title' => 'Transactiegeschiedenis - SG BANK',
    'history_title' => 'Transactiegeschiedenis',
    'history_subtitle' => 'Bekijk al uw financiële transacties',
    'history_overview' => 'Overzicht van uw financiële transacties',
    
    // Exportknoppen
    'export_pdf' => 'Exporteer PDF',
    'export_excel' => 'Exporteer Excel',
    
    // Filters
    'filter_type' => 'Type',
    'filter_status' => 'Status',
    'filter_date_from' => 'Startdatum',
    'filter_date_to' => 'Einddatum',
    'filter_apply' => 'Toepassen',
    
    // Filteropties - Types
    'all_types' => 'Alle types',
    'type_transfer' => 'Overschrijving',
    'type_deposit' => 'Storting',
    'type_withdrawal' => 'Opname',
    
    // Filteropties - Statussen
    'all_statuses' => 'Alle statussen',
    'status_pending' => 'In behandeling',
    'status_on_hold' => 'In de wacht',
    'status_success' => 'Geslaagd',
    'status_failed' => 'Mislukt',
    
    // Tabelkoppen
    'table_transaction' => 'Transactie',
    'table_type' => 'Type',
    'table_amount' => 'Bedrag',
    'table_recipient' => 'Ontvanger',
    'table_status' => 'Status',
    'table_progress' => 'Voortgang',
    'table_date' => 'Datum',
    'table_actions' => 'Acties',
    
    // Acties
    'action_receipt' => 'Ontvangstbewijs',
    'action_download_receipt' => 'Download ontvangstbewijs',
    
    // Lege berichten
    'no_transactions' => 'Geen transacties gevonden',
    'no_transactions_message' => 'Geen transacties komen overeen met uw zoekcriteria.',
    'reset_filters' => 'Filters resetten',
    
    // Paginering
    'showing_results' => ':first tot :last van :total transacties weergeven',
    
    // JavaScript
    'generating' => 'Genereren...',
];
