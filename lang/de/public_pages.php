<?php
$data = require __DIR__ . '/../fr/public_pages.php';
$data['shared'] = [
    'nav_home'=>'Startseite','nav_services'=>'Services','nav_about'=>'Über uns','nav_support'=>'Support','client_area'=>'Kundenbereich','open_account'=>'Konto eröffnen',
    'first_name'=>'Vorname','last_name'=>'Nachname','email'=>'E-Mail-Adresse','phone'=>'Telefon','subject'=>'Betreff','choose_subject'=>'Betreff wählen',
    'subject_support'=>'Kundensupport','subject_commercial'=>'Kontoeröffnung','subject_partnership'=>'Partnerschaft','subject_press'=>'Presse','subject_other'=>'Andere Anfrage',
    'message'=>'Nachricht','message_placeholder'=>'Beschreiben Sie Ihr Anliegen. Wir antworten mit klaren und nutzbaren Informationen.',
    'privacy_notice'=>'Ich akzeptiere, dass Zuider Bank S.A diese Informationen zur Beantwortung meiner Anfrage nutzt.','send_request'=>'Anfrage senden','rights'=>'Alle Rechte vorbehalten.',
];
$t = [
    'services_business'=>['Geschäftskonto','Ein Geschäftskonto für schnelle Entscheidungen, saubere Zahlungen und volle Kontrolle.','Ein klarer und sicherer Banking-Bereich für tägliche und sensible Vorgänge.','Geschäftskonto erstellen','Eine solide Bankbasis für Ihre Tätigkeit.','Bauen Sie Ihre professionelle Bankbasis auf.'],
    'services_international'=>['Internationale Zahlungen','Internationale Überweisungen, die nachvollziehbar, dokumentiert und verständlich sind.','Ihre Transfers behalten vor, während und nach der Bearbeitung eine klare Spur.','Überweisung vorbereiten','Jeder Transfer bleibt nachvollziehbar.','Senden Sie internationale Überweisungen mit mehr Sichtbarkeit.'],
    'services_treasury'=>['Treasury-Management','Treasury, das schnell lesbar und ruhig steuerbar ist.','Saldo, Verlauf, Belege und Hinweise werden leichter nutzbar.','Treasury steuern','Finanzielle Klarheit wird zum Steuerungsvorteil.','Machen Sie Ihr Konto zum Steuerungswerkzeug.'],
    'services_cards'=>['Zahlungskarten','Moderne Karten zum Bezahlen, Verfolgen und Nachweisen.','Eine seriöse Karte mit klarer und sicherer Erfahrung.','Karte anfragen','Eine Karte ist nur nützlich, wenn sie kontrollierbar bleibt.','Geben Sie Ihren Zahlungen eine passende Karte.'],
    'about_story'=>['Unsere Geschichte','Eine Bank, die Klarheit in digitale Finanzen bringt.','Zuider Bank S.A modernisiert Banking ohne Seriosität zu verlieren.','Mein Konto öffnen','Vertrauen, Klarheit und Sicherheit.','Entdecken Sie eine Bank mit Methode.'],
    'about_careers'=>['Karriere','Bauen Sie eine klarere, sicherere und menschlichere Bank mit.','Wir suchen Menschen mit Sinn für gute Produkte und verantwortliche Entscheidungen.','Bewerbung senden','Ein Team, das Präzision bevorzugt.','Möchten Sie eine klarere Bank bauen?'],
    'about_press'=>['Presse und Medien','Presseinformationen zur Entwicklung von Zuider Bank S.A.','Positionierung, Themen und offizielle Informationen.','Presse kontaktieren','Eine digitale Bank mit echtem Anspruch.','Benötigen Sie verlässliche Presseinformationen?'],
    'about_blog'=>['Bankblog','Artikel, um Online-Banking besser zu verstehen.','Leitfäden zu Sicherheit, Überweisungen, Belegen, Karten und Treasury.','Konto eröffnen','Nützliche Inhalte für bessere Entscheidungen.','Vom Lesen ins Handeln kommen.'],
    'support_help'=>['Hilfezentrum','Ein Hilfezentrum für Antworten statt Umwege.','Antworten zu Konto, Sicherheit, Überweisungen und Belegen.','Support kontaktieren','Kurze und handlungsorientierte Antworten.','Benötigen Sie eine persönliche Antwort?'],
    'support_contact'=>['Kontakt','Eine Bankfrage verdient eine klare Antwort.','Schildern Sie Ihr Anliegen zu Support, Konto, Partnerschaft, Presse oder Verwaltung.','Support schreiben','Ein Formular für schnellere Bearbeitung.','Ist Ihre Anfrage bereit?'],
    'support_security'=>['Banksicherheit','Sicherheit muss in jedem Schritt sichtbar sein.','Zuider Bank S.A schützt Zugänge, sensible Vorgänge und überprüfbare Nachweise.','Sicheres Konto eröffnen','Sicherheit für reale Nutzung.','Sichern Sie Ihre Vorgänge mit sichtbaren Nachweisen.'],
    'support_legal'=>['Impressum','Ein verständlicher Rechtsrahmen für Zuider Bank S.A.','Informationen zu Betreiber, Nutzung, Daten und Verantwortung.','Zuider Bank S.A kontaktieren','Konformität beginnt mit verständlichen Informationen.','Fragen zum Rechtsrahmen?'],
];
foreach ($t as $key => $v) { $data['pages'][$key]['eyebrow']=$v[0]; $data['pages'][$key]['title']=$v[1]; $data['pages'][$key]['subtitle']=$v[2]; $data['pages'][$key]['primary_cta']=$v[3]; $data['pages'][$key]['hero_card_title']=$v[4]; $data['pages'][$key]['cta_title']=$v[5]; }
$localizePublicPages = require __DIR__ . '/../public_pages_localizer.php';
return $localizePublicPages($data, 'de');
