<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Linie Językowe Transakcji
    |--------------------------------------------------------------------------
    */

    // Tytuły stron
    'page_title' => 'Nowy przelew - SG BANK',
    'new_transfer' => 'Nowy przelew',

    // Nawigacja
    'dashboard' => 'Panel główny',
    'logout' => 'Wyloguj się',

    // Nagłówki
    'transfer_title' => 'Nowy przelew',
    'transfer_subtitle' => 'Wykonaj bezpieczny przelew na rzecz beneficjenta',

    // Wskaźniki kroków
    'step_information' => 'Informacje',
    'step_processing' => 'Przetwarzanie',
    'step_confirmation' => 'Potwierdzenie',

    // Sekcje formularza
    'transfer_details' => 'Szczegóły przelewu',
    'beneficiary_info' => 'Wprowadź informacje o beneficjencie',
    'banking_details' => 'Dane bankowe',
    'additional_info' => 'Informacje dodatkowe',

    // Etykiety formularza
    'amount' => 'Kwota przelewu',
    'recipient_name' => 'Nazwa beneficjenta',
    'bank_name' => 'Nazwa banku',
    'recipient_iban' => 'IBAN beneficjenta',
    'recipient_bic' => 'BIC beneficjenta',
    'reason' => 'Powód przelewu (opcjonalnie)',
    'activation_code' => 'Kod aktywacyjny',

    // Symbole zastępcze
    'amount_placeholder' => '0.00',
    'recipient_name_placeholder' => 'Jan Kowalski',
    'bank_name_placeholder' => 'Bank Narodowy',
    'iban_placeholder' => 'PL61 1090 1014 0000 0712 1981 2874',
    'bic_placeholder' => 'WBKPPLPPXXX',
    'reason_placeholder' => 'Zwrot, prezent...',
    'activation_code_placeholder' => 'Twój osobisty kod aktywacyjny',

    // Przyciski
    'cancel' => 'Anuluj',
    'start_transfer' => 'Rozpocznij przelew',
    'processing' => 'Przetwarzanie...',

    // Sekcja postępu
    'processing_in_progress' => 'Przetwarzanie w toku',
    'transfer_progress' => 'Postęp przelewu',
    'processing_message' => 'Twój przelew jest przetwarzany. Proszę czekać...',

    // Komunikaty błyskawiczne
    'operation_interrupted' => 'Operacja przerwana',
    'operation_successful' => 'Operacja zakończona sukcesem',
    'transfer_successful' => 'Przelew wykonany pomyślnie. Zostaniesz przekierowany...',
    'understood' => 'Rozumiem',

    // Komunikaty błędów
    'amount_required' => 'Pole kwota jest wymagane.',
    'recipient_name_required' => 'Pole nazwa beneficjenta jest wymagane.',
    'bank_name_required' => 'Pole nazwa banku jest wymagane.',
    'iban_required' => 'Pole IBAN jest wymagane.',
    'bic_required' => 'Pole BIC jest wymagane.',
    'activation_code_required' => 'Pole kod aktywacyjny jest wymagane.',
    'reason_required' => 'Pole powód jest wymagane.',

    // Komunikaty walidacji
    'invalid_amount' => 'Proszę wprowadzić prawidłową kwotę.',
    'invalid_iban' => 'Proszę wprowadzić prawidłowy IBAN.',
    'invalid_bic' => 'Proszę wprowadzić prawidłowy BIC.',
    'invalid_activation_code' => 'Proszę wprowadzić prawidłowy kod aktywacyjny.',

    // Komunikaty statusu
    'transfer_pending' => 'Przelew oczekuje na weryfikację bezpieczeństwa.',
    'connection_error' => 'Błąd połączenia podczas przetwarzania.',

    // Dodatkowe klucze formularza
    'transfer_amount' => 'Kwota Przelew',
    'recipient_iban_placeholder' => 'PL61 1090 1014 0000 0712 1981 2874',
    'recipient_bic_placeholder' => 'WBKPPLPPXXX',
    'transfer_reason' => 'Powód Przelew',
    'transfer_reason_placeholder' => 'Zwrot, prezent...',
    'activation_code_placeholder' => 'Twój osobisty kod aktywacyjny',

    // Komunikaty JavaScript
    'error_starting_transfer' => 'Błąd podczas rozpoczynania przelewu.',
    'connection_error_processing' => 'Błąd połączenia podczas przetwarzania.',
    'transaction_on_hold' => 'Transakcja wstrzymana.',
    'transfer_success_message' => 'Przelew zakończony pomyślnie!',
    'operation_success' => 'Operacja Pomyślna',

    // Etykiety postępu
    'progress_label' => 'Postęp',

    // Strona historii
    'history_page_title' => 'Historia transakcji - SG BANK',
    'history_title' => 'Historia transakcji',
    'history_subtitle' => 'Sprawdź wszystkie swoje operacje finansowe',
    'history_overview' => 'Przegląd Twoich operacji finansowych',
    
    // Przyciski eksportu
    'export_pdf' => 'Eksport PDF',
    'export_excel' => 'Eksport Excel',
    
    // Filtry
    'filter_type' => 'Typ',
    'filter_status' => 'Status',
    'filter_date_from' => 'Data rozpoczęcia',
    'filter_date_to' => 'Data zakończenia',
    'filter_apply' => 'Zastosuj',
    
    // Opcje filtrów - Typy
    'all_types' => 'Wszystkie typy',
    'type_transfer' => 'Przelew',
    'type_deposit' => 'Wpłata',
    'type_withdrawal' => 'Wypłata',
    
    // Opcje filtrów - Statusy
    'all_statuses' => 'Wszystkie statusy',
    'status_pending' => 'Oczekujące',
    'status_on_hold' => 'Wstrzymane',
    'status_success' => 'Udane',
    'status_failed' => 'Nieudane',
    
    // Nagłówki tabeli
    'table_transaction' => 'Transakcja',
    'table_type' => 'Typ',
    'table_amount' => 'Kwota',
    'table_recipient' => 'Odbiorca',
    'table_status' => 'Status',
    'table_progress' => 'Postęp',
    'table_date' => 'Data',
    'table_actions' => 'Akcje',
    
    // Akcje
    'action_receipt' => 'Potwierdzenie',
    'action_download_receipt' => 'Pobierz potwierdzenie',
    
    // Komunikaty puste
    'no_transactions' => 'Nie znaleziono transakcji',
    'no_transactions_message' => 'Żadna transakcja nie odpowiada Twoim kryteriom wyszukiwania.',
    'reset_filters' => 'Zresetuj filtry',
    
    // Paginacja
    'showing_results' => 'Wyświetlanie od :first do :last z :total transakcji',
    
    // JavaScript
    'generating' => 'Generowanie...',
];
