<?php

// Script pour créer les fichiers de traduction pour PL et IT

$translations = [
    'pl' => [
        'home' => [
            // Hero Section
            'hero_badge' => '100% bezpieczna platforma bankowa',
            'hero_title_1' => 'Twój bank online',
            'hero_title_2' => 'profesjonalny i certyfikowany',
            'hero_description' => 'Otwórz konto w kilka minut, śledź przelewy w czasie rzeczywistym i otrzymuj oficjalne potwierdzenia certyfikowane przez SG BANK.',
            'hero_feature_1' => '100% rejestracja online, bez konieczności podróży.',
            'hero_feature_2' => 'Śledzenie przelewów krok po kroku z paskiem postępu.',
            'hero_feature_3' => 'Powiadomienia e-mail dla każdej transakcji.',
            'hero_feature_4' => 'Bezpieczne potwierdzenia PDF zarchiwizowane w Twoim obszarze klienta.',
            'hero_cta_register' => 'Utwórz konto',
            'hero_cta_login' => 'Dostęp do mojej przestrzeni',
            'hero_security_note' => 'SG BANK spełnia najsurowsze standardy bezpieczeństwa, aby chronić Twoje dane finansowe.',
            
            // Dashboard Preview
            'dashboard_preview_title' => 'Podgląd pulpitu',
            'dashboard_transfers_in_progress' => 'Przelewy w toku',
            'dashboard_operations' => 'operacje',
            'dashboard_priority_transfer' => 'Postęp przelewu priorytetowego',
            'dashboard_step' => 'Krok 3/4 - Końcowa kontrola zgodności',
            'dashboard_transfers' => 'Przelewy',
            'dashboard_reception' => 'Odbiór',
            'dashboard_alerts' => 'Alerty',
            'dashboard_description' => 'Nowoczesny, przejrzysty interfejs zaprojektowany dla profesjonalnych przelewów.',
            
            // Navigation
            'nav_home' => 'Strona główna',
            'nav_services' => 'Usługi',
            'nav_testimonials' => 'Opinie klientów',
            'nav_faq' => 'FAQ',
            'nav_contact' => 'Formularz kontaktowy',
            'nav_login' => 'Zaloguj się',
            'nav_register' => 'Utwórz konto',
            
            // Services Menu
            'services_business_accounts' => 'Konta biznesowe',
            'services_international_transfers' => 'Przelewy międzynarodowe',
            'services_treasury_management' => 'Zarządzanie skarbcem',
            'services_payment_cards' => 'Karty płatnicze',
            
            // Features Section
            'features_title' => 'Potężne funkcje zaprojektowane dla profesjonalistów',
            'features_description' => 'SG BANK oferuje nowoczesne doświadczenie bankowe: zaawansowane bezpieczeństwo, pełną przejrzystość i inteligentne zarządzanie operacjami.',
            
            'feature_1_title' => 'Bezpieczeństwo bankowe AES 256-bit',
            'feature_1_description' => 'Twoje dane są szyfrowane end-to-end i chronione tymi samymi protokołami co duże instytucje bankowe.',
            'feature_1_item_1' => 'Bezpieczne połączenie (HTTPS / SSL)',
            'feature_1_item_2' => 'Wykrywanie podejrzanych połączeń',
            'feature_1_item_3' => 'Bezpieczna i chroniona archiwizacja',
            
            'feature_2_title' => 'Monitorowanie antyfraudowe w czasie rzeczywistym',
            'feature_2_description' => 'Inteligentny system stale analizuje Twoje operacje, aby wykryć wszelkie nieprawidłowe działania.',
            'feature_2_item_1' => 'Alerty e-mail w czasie rzeczywistym',
            'feature_2_item_2' => 'Automatyczna analiza anomalii',
            'feature_2_item_3' => 'Możliwa kontrola ręczna przez administratora',
            
            'feature_3_title' => 'Nadzorowany postęp przelewu',
            'feature_3_description' => 'Każdy przelew przechodzi przez certyfikowany proces walidacji, aby zapewnić bezpieczeństwo i przejrzystość.',
            'feature_3_item_1' => 'Śledzenie krok po kroku',
            'feature_3_item_2' => 'Dynamiczny pasek postępu',
            'feature_3_item_3' => 'Certyfikowane potwierdzenie PDF',
            
            // Why Choose Section
            'why_choose_title' => 'Dlaczego wybrać SG BANK?',
            'why_choose_description' => 'SG BANK wspiera zarówno osoby prywatne, jak i profesjonalistów nowoczesnym, dostępnym, szybkim i niezwykle niezawodnym rozwiązaniem bankowym.',
            
            'advantage_1_title' => 'Bez konieczności podróży',
            'advantage_1_description' => 'Otwieraj i zarządzaj kontami z komputera, smartfona lub tabletu, gdziekolwiek jesteś.',
            
            'advantage_2_title' => 'Szybka akceptacja',
            'advantage_2_description' => 'Przyspieszony proces walidacji dla Twoich przelewów i ważnych wniosków.',
            
            'advantage_3_title' => 'Przelewy + potwierdzenie PDF',
            'advantage_3_description' => 'Otrzymaj certyfikowane potwierdzenie PDF po każdym udanym przelewie.',
            
            'advantage_4_title' => 'Ludzkie wsparcie klienta',
            'advantage_4_description' => 'Zespół dostępny, aby Ci pomóc, doradzić i odpowiedzieć na Twoje pytania.',
            
            // Stats Section
            'stats_clients' => 'Zadowoleni klienci',
            'stats_clients_description' => 'Tysiące użytkowników ufa SG BANK w codziennych operacjach.',
            'stats_volume' => 'Wolumen transakcji (M€)',
            'stats_volume_description' => 'Znaczny wolumen przepływów finansowych zarządzanych z precyzją i przejrzystością.',
            'stats_satisfaction' => 'Wskaźnik zadowolenia',
            'stats_satisfaction_description' => 'Nasi użytkownicy polecają SG BANK za prostotę, szybkość i niezawodność.',
            
            // Partners Section
            'partners_title' => 'Ufają nam',
            'partners_description' => 'SG BANK współpracuje z uznanymi na całym świecie instytucjami finansowymi, aby zagwarantować niezawodność, bezpieczeństwo i jakość usług.',
            'partners_note' => 'Wyświetlane logo są prezentowane w celach ilustracyjnych dla demonstracji wizualnej.',
            
            // Certifications Section
            'certifications_title' => 'Certyfikowany według najlepszych standardów',
            'certifications_description' => 'SG BANK stosuje najsurowsze standardy w sektorze bankowym, aby zagwarantować niezawodne, przejrzyste i bezpieczne operacje.',
            
            'cert_1_badge' => 'Certyfikat bezpieczeństwa',
            'cert_1_title' => 'Ulepszone standardy bezpieczeństwa',
            'cert_1_description' => 'Zgodny z międzynarodowymi standardami cyberbezpieczeństwa, zapewniający szyfrowanie na poziomie bankowym.',
            
            'cert_2_badge' => 'Jakość usług',
            'cert_2_title' => 'Doskonałość i przejrzystość',
            'cert_2_description' => 'Szczegółowe śledzenie, wyraźnie wyświetlane opłaty i interfejs zaprojektowany dla użytkowników.',
            'cert_2_distinction' => 'Nagroda za usługi premium',
            
            'cert_3_badge' => 'Ochrona danych',
            'cert_3_title' => 'Gwarantowana poufność',
            'cert_3_description' => 'Ścisłe zarządzanie wrażliwym dostępem i zgodność inspirowana dyrektywami RODO.',
            'cert_3_compliance' => 'Zgodność i bezpieczeństwo danych',
            
            // Testimonials Section
            'testimonials_title' => 'Co mówią nasi klienci',
            'testimonials_description' => 'Prawdziwi użytkownicy, prawdziwe doświadczenia. SG BANK upraszcza codzienne zarządzanie przelewami.',
            
            'testimonial_1_name' => 'Sarah M.',
            'testimonial_1_role' => 'Przedsiębiorca - E-commerce',
            'testimonial_1_text' => 'SG BANK pozwolił mi śledzić przelewy dostawców w czasie rzeczywistym. Pasek postępu i potwierdzenia PDF są naprawdę uspokajające.',
            'testimonial_1_rating' => 'Nienaganna usługa',
            
            'testimonial_2_name' => 'Jean-Paul D.',
            'testimonial_2_role' => 'Doradca finansowy',
            'testimonial_2_text' => 'Szczególnie doceniam monitorowanie antyfraudowe i alerty e-mail. Natychmiast wiem, kiedy ważny przelew jest w toku lub zakończony.',
            'testimonial_2_rating' => 'Bardzo niezawodny',
            
            'testimonial_3_name' => 'Karim L.',
            'testimonial_3_role' => 'Freelancer - Usługa B2B',
            'testimonial_3_text' => 'Interfejs jest przejrzysty i bardzo prosty. Mogę bezpośrednio pokazać klientom dowody przelewu z potwierdzeniami PDF.',
            'testimonial_3_rating' => 'Praktyczny i nowoczesny',
            
            // FAQ Section
            'faq_title' => 'Często zadawane pytania (FAQ)',
            'faq_description' => 'Znajdź odpowiedzi na najczęstsze pytania dotyczące SG BANK, otwierania konta i zarządzania przelewami online.',
            
            'faq_1_question' => 'Jak otworzyć konto w SG BANK?',
            'faq_1_subtitle' => 'Prosta rejestracja w kilku krokach.',
            'faq_1_answer' => 'Kliknij "Utwórz konto", wypełnij formularz swoimi danymi (imię, e-mail, telefon itp.), potwierdź adres e-mail, a następnie uzyskaj dostęp do bezpiecznej przestrzeni, aby wykonać pierwsze operacje.',
            
            'faq_2_question' => 'Czy moje przelewy są naprawdę monitorowane?',
            'faq_2_subtitle' => 'Śledzenie i ręczna kontrola operacji.',
            'faq_2_answer' => 'Tak. Każdy przelew przechodzi przez kilka etapów walidacji. Administratorzy SG BANK mogą kontrolować i certyfikować wrażliwe operacje, co znacznie zmniejsza ryzyko błędu lub oszustwa.',
            
            'faq_3_question' => 'Czy mogę pobrać potwierdzenie dla każdego przelewu?',
            'faq_3_subtitle' => 'Potwierdzenie PDF dostępne.',
            'faq_3_answer' => 'Oczywiście. Po zakończeniu i certyfikacji przelewu automatycznie generowane jest potwierdzenie PDF. Możesz je pobrać, wydrukować lub udostępnić partnerom.',
            
            'faq_4_question' => 'Co zrobić w przypadku problemu lub wątpliwości?',
            'faq_4_subtitle' => 'Dostępne wsparcie ludzkie.',
            'faq_4_answer' => 'Możesz skontaktować się z naszym wsparciem klienta przez bezpieczną przestrzeń lub dane kontaktowe podane na stronie. Doradca odpowie Ci jak najszybciej.',
            
            // CTA Section
            'cta_title' => 'Gotowy do rozpoczęcia?',
            'cta_description' => 'Dołącz do tysięcy zadowolonych klientów, którzy ufają SG BANK w swoich przelewach i operacjach bankowych online.',
            'cta_button' => 'Zacznij teraz',
            'cta_security' => 'Otwarcie konta odbywa się w kilka minut, bez podróży i z wysokim poziomem bezpieczeństwa.',
            
            // Footer
            'footer_description' => '100% bezpieczne, proste i szybkie rozwiązanie bankowe dla profesjonalistów.',
            'footer_services' => 'Usługi',
            'footer_about' => 'O nas',
            'footer_support' => 'Wsparcie',
            'footer_our_story' => 'Nasza historia',
            'footer_careers' => 'Kariera',
            'footer_press' => 'Prasa',
            'footer_blog' => 'Blog',
            'footer_help_center' => 'Centrum pomocy',
            'footer_contact_us' => 'Skontaktuj się z nami',
            'footer_security' => 'Bezpieczeństwo',
            'footer_legal' => 'Informacje prawne',
            'footer_copyright' => 'Wszelkie prawa zastrzeżone.',
            'footer_disclaimer' => 'Informacje wyświetlane na tej stronie mają charakter orientacyjny i mogą być dostosowane do Twojego rzeczywistego projektu.',
        ],
        'common' => [
            // Actions
            'save' => 'Zapisz',
            'cancel' => 'Anuluj',
            'delete' => 'Usuń',
            'edit' => 'Edytuj',
            'create' => 'Utwórz',
            'update' => 'Aktualizuj',
            'submit' => 'Prześlij',
            'search' => 'Szukaj',
            'filter' => 'Filtruj',
            'export' => 'Eksportuj',
            'import' => 'Importuj',
            'download' => 'Pobierz',
            'upload' => 'Prześlij',
            'view' => 'Zobacz',
            'back' => 'Wstecz',
            'next' => 'Następny',
            'previous' => 'Poprzedni',
            'close' => 'Zamknij',
            'confirm' => 'Potwierdź',
            'send' => 'Wyślij',
            'refresh' => 'Odśwież',
            'reset' => 'Resetuj',
            'clear' => 'Wyczyść',
            'apply' => 'Zastosuj',
            
            // Status
            'status' => 'Status',
            'active' => 'Aktywny',
            'inactive' => 'Nieaktywny',
            'pending' => 'Oczekujący',
            'approved' => 'Zatwierdzony',
            'rejected' => 'Odrzucony',
            'completed' => 'Zakończony',
            'cancelled' => 'Anulowany',
            'processing' => 'Przetwarzanie',
            'failed' => 'Nieudany',
            'success' => 'Sukces',
            
            // Common words
            'yes' => 'Tak',
            'no' => 'Nie',
            'all' => 'Wszystkie',
            'none' => 'Żaden',
            'other' => 'Inny',
            'total' => 'Razem',
            'amount' => 'Kwota',
            'date' => 'Data',
            'time' => 'Czas',
            'description' => 'Opis',
            'details' => 'Szczegóły',
            'actions' => 'Akcje',
            'options' => 'Opcje',
            'settings' => 'Ustawienia',
            'loading' => 'Ładowanie...',
            'no_data' => 'Brak dostępnych danych',
            'error' => 'Błąd',
            'warning' => 'Ostrzeżenie',
            'info' => 'Informacja',
            'required' => 'Wymagane',
            'optional' => 'Opcjonalne',
            
            // Messages
            'success_message' => 'Operacja zakończona sukcesem!',
            'error_message' => 'Wystąpił błąd. Spróbuj ponownie.',
            'confirm_delete' => 'Czy na pewno chcesz usunąć ten element?',
            'no_results' => 'Nie znaleziono wyników.',
            'please_wait' => 'Proszę czekać...',
            'language_changed' => 'Język zmieniony pomyślnie!',
            
            // Time
            'today' => 'Dziś',
            'yesterday' => 'Wczoraj',
            'tomorrow' => 'Jutro',
            'this_week' => 'Ten tydzień',
            'this_month' => 'Ten miesiąc',
            'this_year' => 'Ten rok',
            
            // Currency
            'currency' => 'Waluta',
            'eur' => 'Euro (EUR)',
            'usd' => 'Dolar amerykański (USD)',
            'gbp' => 'Funt brytyjski (GBP)',
            'chf' => 'Frank szwajcarski (CHF)',
        ]
    ],
    'it' => [
        'home' => [
            // Hero Section
            'hero_badge' => 'Piattaforma bancaria 100% sicura',
            'hero_title_1' => 'La tua banca online',
            'hero_title_2' => 'professionale e certificata',
            'hero_description' => 'Apri il tuo conto in pochi minuti, segui i tuoi bonifici in tempo reale e ricevi ricevute ufficiali certificate da SG BANK.',
            'hero_feature_1' => 'Registrazione 100% online, nessun viaggio necessario.',
            'hero_feature_2' => 'Tracciamento passo dopo passo dei bonifici con barra di avanzamento.',
            'hero_feature_3' => 'Notifiche email per ogni transazione.',
            'hero_feature_4' => 'Ricevute PDF sicure archiviate nella tua area cliente.',
            'hero_cta_register' => 'Crea il mio account',
            'hero_cta_login' => 'Accedi al mio spazio',
            'hero_security_note' => 'SG BANK rispetta i più rigorosi standard di sicurezza per proteggere i tuoi dati finanziari.',
            
            // Dashboard Preview
            'dashboard_preview_title' => 'Anteprima della tua dashboard',
            'dashboard_transfers_in_progress' => 'Bonifici in corso',
            'dashboard_operations' => 'operazioni',
            'dashboard_priority_transfer' => 'Avanzamento bonifico prioritario',
            'dashboard_step' => 'Passo 3/4 - Controllo finale di conformità',
            'dashboard_transfers' => 'Bonifici',
            'dashboard_reception' => 'Ricezione',
            'dashboard_alerts' => 'Avvisi',
            'dashboard_description' => 'Interfaccia moderna e chiara progettata per bonifici professionali.',
            
            // Navigation
            'nav_home' => 'Home',
            'nav_services' => 'Servizi',
            'nav_testimonials' => 'Testimonianze clienti',
            'nav_faq' => 'FAQ',
            'nav_contact' => 'Modulo di contatto',
            'nav_login' => 'Accedi',
            'nav_register' => 'Crea account',
            
            // Services Menu
            'services_business_accounts' => 'Conti aziendali',
            'services_international_transfers' => 'Bonifici internazionali',
            'services_treasury_management' => 'Gestione tesoreria',
            'services_payment_cards' => 'Carte di pagamento',
            
            // Features Section
            'features_title' => 'Funzionalità potenti progettate per professionisti',
            'features_description' => 'SG BANK ti offre un\'esperienza bancaria moderna: sicurezza avanzata, trasparenza totale e gestione intelligente delle tue operazioni.',
            
            'feature_1_title' => 'Sicurezza bancaria AES a 256 bit',
            'feature_1_description' => 'I tuoi dati sono crittografati end-to-end e protetti dagli stessi protocolli delle grandi istituzioni bancarie.',
            'feature_1_item_1' => 'Connessione sicura (HTTPS / SSL)',
            'feature_1_item_2' => 'Rilevamento connessioni sospette',
            'feature_1_item_3' => 'Archiviazione sicura e protetta',
            
            'feature_2_title' => 'Monitoraggio antifrode in tempo reale',
            'feature_2_description' => 'Un sistema intelligente analizza continuamente le tue operazioni per rilevare qualsiasi attività anomala.',
            'feature_2_item_1' => 'Avvisi email in tempo reale',
            'feature_2_item_2' => 'Analisi automatica delle anomalie',
            'feature_2_item_3' => 'Controllo manuale possibile dall\'amministratore',
            
            'feature_3_title' => 'Avanzamento bonifico supervisionato',
            'feature_3_description' => 'Ogni bonifico passa attraverso un processo di convalida certificato per garantire sicurezza e trasparenza.',
            'feature_3_item_1' => 'Tracciamento passo dopo passo',
            'feature_3_item_2' => 'Barra di avanzamento dinamica',
            'feature_3_item_3' => 'Ricevuta PDF certificata',
            
            // Why Choose Section
            'why_choose_title' => 'Perché scegliere SG BANK?',
            'why_choose_description' => 'SG BANK supporta sia privati che professionisti con una soluzione bancaria moderna, accessibile, veloce ed estremamente affidabile.',
            
            'advantage_1_title' => 'Nessun viaggio necessario',
            'advantage_1_description' => 'Apri e gestisci i tuoi conti dal tuo computer, smartphone o tablet, ovunque tu sia.',
            
            'advantage_2_title' => 'Approvazione rapida',
            'advantage_2_description' => 'Processo di convalida accelerato per i tuoi bonifici e richieste importanti.',
            
            'advantage_3_title' => 'Bonifici + ricevuta PDF',
            'advantage_3_description' => 'Ricevi una ricevuta PDF certificata dopo ogni bonifico riuscito.',
            
            'advantage_4_title' => 'Supporto clienti umano',
            'advantage_4_description' => 'Un team disponibile per aiutarti, consigliarti e rispondere alle tue domande.',
            
            // Stats Section
            'stats_clients' => 'Clienti soddisfatti',
            'stats_clients_description' => 'Migliaia di utenti si fidano di SG BANK per le loro operazioni quotidiane.',
            'stats_volume' => 'Volume transazioni (M€)',
            'stats_volume_description' => 'Un volume significativo di flussi finanziari gestiti con precisione e trasparenza.',
            'stats_satisfaction' => 'Tasso di soddisfazione',
            'stats_satisfaction_description' => 'I nostri utenti raccomandano SG BANK per la sua semplicità, velocità e affidabilità.',
            
            // Partners Section
            'partners_title' => 'Si fidano di noi',
            'partners_description' => 'SG BANK collabora con istituzioni finanziarie riconosciute a livello mondiale per garantire affidabilità, sicurezza e qualità del servizio.',
            'partners_note' => 'I loghi visualizzati sono presentati a scopo illustrativo per una dimostrazione visiva.',
            
            // Certifications Section
            'certifications_title' => 'Certificato secondo i migliori standard',
            'certifications_description' => 'SG BANK applica gli standard più rigorosi del settore bancario per garantire operazioni affidabili, trasparenti e sicure.',
            
            'cert_1_badge' => 'Certificazione di sicurezza',
            'cert_1_title' => 'Standard di sicurezza avanzati',
            'cert_1_description' => 'Conforme agli standard internazionali di cybersicurezza, garantendo crittografia di livello bancario.',
            
            'cert_2_badge' => 'Qualità del servizio',
            'cert_2_title' => 'Eccellenza e trasparenza',
            'cert_2_description' => 'Tracciamento dettagliato, tariffe chiaramente visualizzate e un\'interfaccia progettata per gli utenti.',
            'cert_2_distinction' => 'Premio servizio premium',
            
            'cert_3_badge' => 'Protezione dati',
            'cert_3_title' => 'Riservatezza garantita',
            'cert_3_description' => 'Gestione rigorosa degli accessi sensibili e conformità ispirata alle direttive GDPR.',
            'cert_3_compliance' => 'Conformità e sicurezza dei dati',
            
            // Testimonials Section
            'testimonials_title' => 'Cosa dicono i nostri clienti',
            'testimonials_description' => 'Utenti reali, esperienze reali. SG BANK semplifica la gestione quotidiana dei bonifici.',
            
            'testimonial_1_name' => 'Sarah M.',
            'testimonial_1_role' => 'Imprenditrice - E-commerce',
            'testimonial_1_text' => 'SG BANK mi ha permesso di seguire i miei bonifici ai fornitori in tempo reale. La barra di avanzamento e le ricevute PDF sono davvero rassicuranti.',
            'testimonial_1_rating' => 'Servizio impeccabile',
            
            'testimonial_2_name' => 'Jean-Paul D.',
            'testimonial_2_role' => 'Consulente finanziario',
            'testimonial_2_text' => 'Apprezzo particolarmente il monitoraggio antifrode e gli avvisi email. So immediatamente quando un bonifico importante è in corso o completato.',
            'testimonial_2_rating' => 'Molto affidabile',
            
            'testimonial_3_name' => 'Karim L.',
            'testimonial_3_role' => 'Freelancer - Servizio B2B',
            'testimonial_3_text' => 'L\'interfaccia è chiara e molto semplice. Posso mostrare direttamente ai miei clienti le prove di bonifico con ricevute PDF.',
            'testimonial_3_rating' => 'Pratico e moderno',
            
            // FAQ Section
            'faq_title' => 'Domande frequenti (FAQ)',
            'faq_description' => 'Trova risposte alle domande più comuni su SG BANK, apertura conto e gestione dei tuoi bonifici online.',
            
            'faq_1_question' => 'Come aprire un conto su SG BANK?',
            'faq_1_subtitle' => 'Registrazione semplice in pochi passaggi.',
            'faq_1_answer' => 'Clicca su "Crea account", compila il modulo con le tue informazioni (nome, email, telefono, ecc.), conferma il tuo indirizzo email, quindi accedi al tuo spazio sicuro per effettuare le tue prime operazioni.',
            
            'faq_2_question' => 'I miei bonifici sono davvero monitorati?',
            'faq_2_subtitle' => 'Tracciamento e controllo manuale delle operazioni.',
            'faq_2_answer' => 'Sì. Ogni bonifico passa attraverso diverse fasi di convalida. Gli amministratori di SG BANK possono controllare e certificare operazioni sensibili, riducendo notevolmente il rischio di errore o frode.',
            
            'faq_3_question' => 'Posso scaricare una ricevuta per ogni bonifico?',
            'faq_3_subtitle' => 'Ricevuta PDF disponibile.',
            'faq_3_answer' => 'Certamente. Una volta completato e certificato il bonifico, viene generata automaticamente una ricevuta PDF. Puoi scaricarla, stamparla o condividerla con i tuoi partner.',
            
            'faq_4_question' => 'Cosa fare in caso di problema o dubbio?',
            'faq_4_subtitle' => 'Supporto umano disponibile.',
            'faq_4_answer' => 'Puoi contattare il nostro supporto clienti tramite il tuo spazio sicuro o tramite i dati di contatto indicati sul sito. Un consulente ti risponderà il prima possibile.',
            
            // CTA Section
            'cta_title' => 'Pronto per iniziare?',
            'cta_description' => 'Unisciti a migliaia di clienti soddisfatti che si fidano di SG BANK per i loro bonifici e operazioni bancarie online.',
            'cta_button' => 'Crea il tuo account',
            'cta_security' => 'L\'apertura del conto avviene in pochi minuti, senza viaggi e con un alto livello di sicurezza.',
            
            // Footer
            'footer_copyright' => 'Tutti i diritti riservati.',
            'footer_privacy' => 'Informativa sulla privacy',
            'footer_terms' => 'Termini e condizioni',
            'footer_support' => 'Supporto clienti',
        ],