<?php

/**
 * Script pour créer les fichiers de traduction auth.php pour toutes les langues
 */

// Définir les traductions pour chaque langue
$translations = [
    'de' => [
        'title' => 'Deutsch (German)',
        'translations' => [
            // Error messages
            'failed' => 'Diese Anmeldeinformationen stimmen nicht mit unseren Aufzeichnungen überein.',
            'password' => 'Das angegebene Passwort ist falsch.',
            'throttle' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
            
            // Login page
            'login_page_title' => 'Anmeldung - SG BANK',
            'nav_home' => 'Startseite',
            'nav_create_account' => 'Konto erstellen',
            'nav_login' => 'Anmeldung',
            'login_hero_title' => 'Zugriff auf Ihren sicheren Bereich',
            'login_hero_description' => 'Verwalten Sie Ihre Konten, verfolgen Sie Ihre Transaktionen, erhalten Sie Benachrichtigungen in Echtzeit und greifen Sie auf unsere professionellen Dienste zu.',
            'login_feature_security' => 'Sicherheit auf Bankniveau',
            'login_feature_notifications' => 'Benachrichtigungen in Echtzeit',
            'login_feature_analytics' => 'Analyse-Dashboard',
            'login_title' => 'Anmeldung',
            'login_subtitle' => 'Geben Sie Ihre Anmeldeinformationen ein, um auf Ihr Konto zuzugreifen.',
            'email' => 'E-Mail-Adresse',
            'email_placeholder' => 'sie@beispiel.com',
            'password' => 'Passwort',
            'password_placeholder' => '••••••••',
            'remember_me' => 'Angemeldet bleiben',
            'forgot_password' => 'Passwort vergessen?',
            'login_button' => 'Anmelden',
            'or' => 'Oder',
            'no_account' => 'Kein Konto?',
            'register_link' => 'Registrieren',
            'login_with_google' => 'Google',
            'login_with_apple' => 'Apple',
            
            // Register page
            'register_page_title' => 'Registrierung - SG BANK',
            'register_hero_title_1' => 'Eröffnen Sie Ihr',
            'register_hero_title_2' => 'Konto',
            'register_hero_title_3' => 'in wenigen',
            'register_hero_title_4' => 'Minuten',
            'register_hero_description_1' => 'Einfach,',
            'register_hero_description_2' => 'sicher',
            'register_hero_description_3' => 'und entwickelt, um',
            'register_hero_description_4' => 'schnell',
            'register_feature_fast' => 'Registrierung',
            'register_feature_fast_bold' => 'schnell',
            'register_feature_security' => 'Sicherheitsniveau',
            'register_feature_security_bold' => 'Banking',
            'register_feature_notifications' => 'Benachrichtigungen in',
            'register_feature_notifications_bold' => 'Echtzeit',
            'register_title' => 'Treten Sie SG BANK bei',
            'already_account' => 'Bereits registriert?',
            'login_link' => 'Anmelden',
            
            // Form fields
            'first_name' => 'Vorname',
            'first_name_placeholder' => 'Hans',
            'last_name' => 'Nachname',
            'last_name_placeholder' => 'Schmidt',
            'email_address' => 'E-Mail-Adresse',
            'email_address_placeholder' => 'beispiel@mail.com',
            'phone' => 'Telefon',
            'phone_placeholder' => '+49 123 456 7890',
            'address' => 'Adresse',
            'address_placeholder' => 'Hauptstraße 12, Berlin',
            'country' => 'Land',
            'country_select' => 'Land auswählen',
            'city' => 'Stadt',
            'city_placeholder' => 'Berlin',
            'date_of_birth' => 'Geburtsdatum',
            'id_type' => 'Ausweistyp',
            'id_type_select' => 'Auswählen',
            'id_type_cni' => 'Personalausweis',
            'id_type_passport' => 'Reisepass',
            'id_type_license' => 'Führerschein',
            'id_number' => 'Ausweisnummer',
            'id_number_placeholder' => 'z.B.: DE1234567',
            'iban' => 'IBAN (optional)',
            'iban_placeholder' => 'DE89 3704 0044 0532 0130 00',
            'password_field' => 'Passwort',
            'password_strength' => 'Passwortstärke',
            'confirm_password' => 'Passwort bestätigen',
            
            // Countries
            'country_france' => '(FR) Frankreich',
            'country_germany' => '(DE) Deutschland',
            'country_austria' => '(AT) Österreich',
            'country_belgium' => '(BE) Belgien',
            'country_bulgaria' => '(BG) Bulgarien',
            'country_cyprus' => '(CY) Zypern',
            'country_croatia' => '(HR) Kroatien',
            'country_denmark' => '(DK) Dänemark',
            'country_spain' => '(ES) Spanien',
            'country_estonia' => '(EE) Estland',
            'country_finland' => '(FI) Finnland',
            'country_greece' => '(GR) Griechenland',
            'country_hungary' => '(HU) Ungarn',
            'country_ireland' => '(IE) Irland',
            'country_italy' => '(IT) Italien',
            'country_latvia' => '(LV) Lettland',
            'country_lithuania' => '(LT) Litauen',
            'country_luxembourg' => '(LU) Luxemburg',
            'country_malta' => '(MT) Malta',
            'country_netherlands' => '(NL) Niederlande',
            'country_poland' => '(PL) Polen',
            'country_portugal' => '(PT) Portugal',
            'country_czech' => '(CZ) Tschechische Republik',
            'country_romania' => '(RO) Rumänien',
            'country_slovakia' => '(SK) Slowakei',
            'country_slovenia' => '(SI) Slowenien',
            'country_sweden' => '(SE) Schweden',
            'country_switzerland' => '(CH) Schweiz',
            'country_norway' => '(NO) Norwegen',
            'country_iceland' => '(IS) Island',
            'country_uk' => '(GB) Vereinigtes Königreich',
            'country_albania' => '(AL) Albanien',
            'country_bosnia' => '(BA) Bosnien und Herzegowina',
            'country_serbia' => '(RS) Serbien',
            'country_montenegro' => '(ME) Montenegro',
            'country_macedonia' => '(MK) Nordmazedonien',
            'country_kosovo' => '(XK) Kosovo',
            'country_andorra' => '(AD) Andorra',
            'country_liechtenstein' => '(LI) Liechtenstein',
            'country_monaco' => '(MC) Monaco',
            'country_san_marino' => '(SM) San Marino',
            'country_vatican' => '(VA) Vatikan',
            'country_canada' => 'Kanada',
            'country_other' => 'Andere',
            
            // Terms
            'terms_accept' => 'Ich akzeptiere die',
            'terms_link' => 'Nutzungsbedingungen',
            'terms_and' => 'und die',
            'privacy_link' => 'Datenschutzrichtlinie',
            'register_button' => 'Mein Konto erstellen',
            
            // Footer
            'footer_copyright' => 'Alle Rechte vorbehalten.',
            'footer_privacy' => 'Datenschutz',
            'footer_terms' => 'Bedingungen',
            'footer_support' => 'Unterstützung',
            
            // Success messages
            'login_success' => 'Erfolgreich angemeldet!',
            'logout_success' => 'Erfolgreich abgemeldet!',
            'register_success' => 'Registrierung erfolgreich! Bitte warten Sie auf die Genehmigung des Administrators.',
            'password_reset_success' => 'Ihr Passwort wurde erfolgreich zurückgesetzt!',
            
            // Password reset
            'reset_password' => 'Passwort zurücksetzen',
            'send_reset_link' => 'Link zum Zurücksetzen des Passworts senden',
            'reset_link_sent' => 'Wir haben Ihnen den Link zum Zurücksetzen des Passworts per E-Mail gesendet!',
            'reset_password_title' => 'Setzen Sie Ihr Passwort zurück',
            'new_password' => 'Neues Passwort',
            'confirm_new_password' => 'Neues Passwort bestätigen',
            'logout' => 'Abmelden',
        ]
    ],
    
    'nl' => [
        'title' => 'Nederlands (Dutch)',
        'translations' => [
            // Error messages
            'failed' => 'Deze inloggegevens komen niet overeen met onze gegevens.',
            'password' => 'Het opgegeven wachtwoord is onjuist.',
            'throttle' => 'Te veel inlogpogingen. Probeer het over :seconds seconden opnieuw.',
            
            // Login page
            'login_page_title' => 'Inloggen - SG BANK',
            'nav_home' => 'Home',
            'nav_create_account' => 'Account aanmaken',
            'nav_login' => 'Inloggen',
            'login_hero_title' => 'Toegang tot uw beveiligde ruimte',
            'login_hero_description' => 'Beheer uw accounts, volg uw transacties, ontvang realtime meldingen en krijg toegang tot onze professionele diensten.',
            'login_feature_security' => 'Beveiliging op bankniveau',
            'login_feature_notifications' => 'Realtime meldingen',
            'login_feature_analytics' => 'Analyse dashboard',
            'login_title' => 'Inloggen',
            'login_subtitle' => 'Voer uw inloggegevens in om toegang te krijgen tot uw account.',
            'email' => 'E-mailadres',
            'email_placeholder' => 'u@voorbeeld.com',
            'password' => 'Wachtwoord',
            'password_placeholder' => '••••••••',
            'remember_me' => 'Onthoud mij',
            'forgot_password' => 'Wachtwoord vergeten?',
            'login_button' => 'Inloggen',
            'or' => 'Of',
            'no_account' => 'Geen account?',
            'register_link' => 'Registreren',
            'login_with_google' => 'Google',
            'login_with_apple' => 'Apple',
            
            // Register page
            'register_page_title' => 'Registreren - SG BANK',
            'register_hero_title_1' => 'Open uw',
            'register_hero_title_2' => 'account',
            'register_hero_title_3' => 'in een paar',
            'register_hero_title_4' => 'minuten',
            'register_hero_description_1' => 'Eenvoudig,',
            'register_hero_description_2' => 'veilig',
            'register_hero_description_3' => 'en ontworpen om',
            'register_hero_description_4' => 'snel',
            'register_feature_fast' => 'Registratie',
            'register_feature_fast_bold' => 'snel',
            'register_feature_security' => 'Beveiligingsniveau',
            'register_feature_security_bold' => 'bankieren',
            'register_feature_notifications' => 'Meldingen in',
            'register_feature_notifications_bold' => 'realtime',
            'register_title' => 'Word lid van SG BANK',
            'already_account' => 'Al geregistreerd?',
            'login_link' => 'Inloggen',
            
            // Form fields
            'first_name' => 'Voornaam',
            'first_name_placeholder' => 'Jan',
            'last_name' => 'Achternaam',
            'last_name_placeholder' => 'de Vries',
            'email_address' => 'E-mailadres',
            'email_address_placeholder' => 'voorbeeld@mail.com',
            'phone' => 'Telefoon',
            'phone_placeholder' => '+31 6 12345678',
            'address' => 'Adres',
            'address_placeholder' => 'Hoofdstraat 12, Amsterdam',
            'country' => 'Land',
            'country_select' => 'Selecteer een land',
            'city' => 'Stad',
            'city_placeholder' => 'Amsterdam',
            'date_of_birth' => 'Geboortedatum',
            'id_type' => 'ID-type',
            'id_type_select' => 'Selecteren',
            'id_type_cni' => 'Identiteitskaart',
            'id_type_passport' => 'Paspoort',
            'id_type_license' => 'Rijbewijs',
            'id_number' => 'ID-nummer',
            'id_number_placeholder' => 'Bijv.: NL1234567',
            'iban' => 'IBAN (optioneel)',
            'iban_placeholder' => 'NL91 ABNA 0417 1643 00',
            'password_field' => 'Wachtwoord',
            'password_strength' => 'Wachtwoordsterkte',
            'confirm_password' => 'Bevestig wachtwoord',
            
            // Countries (same as German but in Dutch)
            'country_france' => '(FR) Frankrijk',
            'country_germany' => '(DE) Duitsland',
            'country_austria' => '(AT) Oostenrijk',
            'country_belgium' => '(BE) België',
            'country_bulgaria' => '(BG) Bulgarije',
            'country_cyprus' => '(CY) Cyprus',
            'country_croatia' => '(HR) Kroatië',
            'country_denmark' => '(DK) Denemarken',
            'country_spain' => '(ES) Spanje',
            'country_estonia' => '(EE) Estland',
            'country_finland' => '(FI) Finland',
            'country_greece' => '(GR) Griekenland',
            'country_hungary' => '(HU) Hongarije',
            'country_ireland' => '(IE) Ierland',
            'country_italy' => '(IT) Italië',
            'country_latvia' => '(LV) Letland',
            'country_lithuania' => '(LT) Litouwen',
            'country_luxembourg' => '(LU) Luxemburg',
            'country_malta' => '(MT) Malta',
            'country_netherlands' => '(NL) Nederland',
            'country_poland' => '(PL) Polen',
            'country_portugal' => '(PT) Portugal',
            'country_czech' => '(CZ) Tsjechië',
            'country_romania' => '(RO) Roemenië',
            'country_slovakia' => '(SK) Slowakije',
            'country_slovenia' => '(SI) Slovenië',
            'country_sweden' => '(SE) Zweden',
            'country_switzerland' => '(CH) Zwitserland',
            'country_norway' => '(NO) Noorwegen',
            'country_iceland' => '(IS) IJsland',
            'country_uk' => '(GB) Verenigd Koninkrijk',
            'country_albania' => '(AL) Albanië',
            'country_bosnia' => '(BA) Bosnië en Herzegovina',
            'country_serbia' => '(RS) Servië',
            'country_montenegro' => '(ME) Montenegro',
            'country_macedonia' => '(MK) Noord-Macedonië',
            'country_kosovo' => '(XK) Kosovo',
            'country_andorra' => '(AD) Andorra',
            'country_liechtenstein' => '(LI) Liechtenstein',
            'country_monaco' => '(MC) Monaco',
            'country_san_marino' => '(SM) San Marino',
            'country_vatican' => '(VA) Vaticaanstad',
            'country_canada' => 'Canada',
            'country_other' => 'Andere',
            
            // Terms
            'terms_accept' => 'Ik accepteer de',
            'terms_link' => 'gebruiksvoorwaarden',
            'terms_and' => 'en het',
            'privacy_link' => 'privacybeleid',
            'register_button' => 'Mijn account aanmaken',
            
            // Footer
            'footer_copyright' => 'Alle rechten voorbehouden.',
            'footer_privacy' => 'Privacy',
            'footer_terms' => 'Voorwaarden',
            'footer_support' => 'Ondersteuning',
            
            // Success messages
            'login_success' => 'Succesvol ingelogd!',
            'logout_success' => 'Succesvol uitgelogd!',
            'register_success' => 'Registratie succesvol! Wacht op goedkeuring van de beheerder.',
            'password_reset_success' => 'Uw wachtwoord is succesvol gereset!',
            
            // Password reset
            'reset_password' => 'Wachtwoord resetten',
            'send_reset_link' => 'Verstuur reset link',
            'reset_link_sent' => 'We hebben u de reset link per e-mail gestuurd!',
            'reset_password_title' => 'Reset uw wachtwoord',
            'new_password' => 'Nieuw wachtwoord',
            'confirm_new_password' => 'Bevestig nieuw wachtwoord',
            'logout' => 'Uitloggen',
        ]
    ],
];

// Créer les fichiers pour chaque langue
foreach ($translations as $lang => $data) {
    $dir = __DIR__ . "/lang/{$lang}";
    
    // Créer le répertoire s'il n'existe pas
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✓ Répertoire créé: {$dir}\n";
    }
    
    $filePath = "{$dir}/auth.php";
    
    // Générer le contenu du fichier
    $content = "<?php\n\nreturn [\n";
    $content .= "    /*\n";
    $content .= "    |--------------------------------------------------------------------------\n";
    $content .= "    | Auth Language Lines - {$data['title']}\n";
    $content .= "    |--------------------------------------------------------------------------\n";
    $content .= "    */\n\n";
    
    $lastCategory = '';
    foreach ($data['translations'] as $key => $value) {
        // Détecter les catégories pour ajouter des commentaires
        $category = '';
        if (strpos($key, 'failed') === 0 || strpos($key, 'password') === 0 || strpos($key, 'throttle') === 0) {
            $category = 'error';
        } elseif (strpos($key, 'login_page') === 0 || strpos($key, 'nav_') === 0) {
            $category = 'navigation';
        } elseif (strpos($key, 'login_hero') === 0 || strpos($key, 'login_feature') === 0) {
            $category = 'login_hero';
        } elseif (strpos($key, 'login_') === 0 && $category !== 'login_hero') {
            $category = 'login_form';
        } elseif (strpos($key, 'register_page') === 0 || strpos($key, 'register_hero') === 0 || strpos($key, 'register_feature') === 0) {
            $category = 'register_hero';
        } elseif (strpos($key, 'register_') === 0 && $category !== 'register_hero') {
            $category = 'register_form';
        } elseif (strpos($key, 'first_name') === 0 || strpos($key, 'last_name') === 0 || strpos($key, 'email_address') === 0) {
            $category = 'form_fields';
        } elseif (strpos($key, 'country_') === 0) {
            $category = 'countries';
        } elseif (strpos($key, 'terms_') === 0 || strpos($key, 'privacy_') === 0) {
            $category = 'terms';
        } elseif (strpos($key, 'footer_') === 0) {
            $category = 'footer';
        } elseif (strpos($key, 'login_success') === 0 || strpos($key, 'logout_success') === 0 || strpos($key, 'register_success') === 0) {
            $category = 'success_messages';
        } elseif (strpos($key, 'reset_') === 0) {
            $category = 'password_reset';
        }        
        
        if ($category !== $lastCategory) {
            $content .= "    // {$category}\n";
            $lastCategory = $category;
        }
        
        $content .= "    '{$key}' => '{$value}',\n";
    }
    
    $content .= "];\n";
    
    // Créer le fichier
    file_put_contents($filePath, $content);
    echo "✓ Fichier créé: {$filePath}\n";
}
