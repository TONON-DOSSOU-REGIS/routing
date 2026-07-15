<?php
$data = require __DIR__ . '/../fr/public_pages.php';
$data['shared'] = [
    'nav_home'=>'Strona główna','nav_services'=>'Usługi','nav_about'=>'O nas','nav_support'=>'Pomoc','client_area'=>'Strefa klienta','open_account'=>'Otwórz konto',
    'first_name'=>'Imię','last_name'=>'Nazwisko','email'=>'Adres e-mail','phone'=>'Telefon','subject'=>'Temat','choose_subject'=>'Wybierz temat',
    'subject_support'=>'Obsługa klienta','subject_commercial'=>'Otwarcie konta','subject_partnership'=>'Partnerstwo','subject_press'=>'Prasa','subject_other'=>'Inna prośba',
    'message'=>'Wiadomość','message_placeholder'=>'Opisz swoją potrzebę. Odpowiemy jasno i konkretnie.',
    'privacy_notice'=>'Zgadzam się, aby Zuider Bank S.A użył tych informacji do odpowiedzi na moją prośbę.','send_request'=>'Wyślij prośbę','rights'=>'Wszelkie prawa zastrzeżone.',
];
$t = [
    'services_business'=>['Konto firmowe','Konto firmowe do szybkich decyzji, przejrzystych płatności i kontroli.','Jasna i bezpieczna przestrzeń bankowa dla codziennych oraz wrażliwych operacji.','Utwórz konto firmowe','Solidna baza bankowa dla Twojej działalności.','Zbuduj profesjonalną bazę bankową.'],
    'services_international'=>['Płatności międzynarodowe','Przelewy międzynarodowe śledzone, udokumentowane i zrozumiałe.','Twoje przelewy zachowują jasny ślad przed, w trakcie i po realizacji.','Przygotuj przelew','Każdy przelew ma czytelny zapis.','Wysyłaj przelewy z większą widocznością.'],
    'services_treasury'=>['Zarządzanie treasury','Treasury czytelne szybko i prowadzone spokojnie.','Saldo, historia, dokumenty i alerty stają się łatwiejsze w użyciu.','Zarządzaj treasury','Przejrzystość finansowa staje się przewagą.','Zmień konto w narzędzie kontroli.'],
    'services_cards'=>['Karty płatnicze','Nowoczesne karty do płatności, śledzenia i rozliczania.','Poważna karta bankowa połączona z jasnym i bezpiecznym doświadczeniem.','Zamów kartę','Karta jest użyteczna, gdy pozostaje pod kontrolą.','Daj swoim płatnościom kartę na poziomie banku.'],
    'about_story'=>['Nasza historia','Bank stworzony, aby przywrócić jasność finansom cyfrowym.','Zuider Bank S.A modernizuje bankowość bez utraty powagi.','Otwórz swoją przestrzeń','Zaufanie, jasność i bezpieczeństwo.','Poznaj bank, który rozwija się metodycznie.'],
    'about_careers'=>['Kariera','Buduj bardziej przejrzysty, bezpieczny i ludzki bank.','Szukamy osób ceniących dobre produkty i odpowiedzialne decyzje.','Wyślij kandydaturę','Zespół, który wybiera precyzję zamiast szumu.','Chcesz budować bardziej przejrzysty bank?'],
    'about_press'=>['Prasa i media','Materiały prasowe o rozwoju Zuider Bank S.A.','Znajdź pozycjonowanie, tematy i oficjalne informacje.','Kontakt dla prasy','Cyfrowy bank traktujący powagę serio.','Potrzebujesz wiarygodnych informacji prasowych?'],
    'about_blog'=>['Blog bankowy','Artykuły pomagające zrozumieć bankowość online.','Poradniki o bezpieczeństwie, przelewach, potwierdzeniach, kartach i treasury.','Otwórz konto','Przydatna lektura dla lepszych decyzji.','Przejdź od czytania do działania.'],
    'support_help'=>['Centrum pomocy','Centrum pomocy stworzone do znajdowania odpowiedzi.','Najważniejsze odpowiedzi o koncie, bezpieczeństwie, przelewach i potwierdzeniach.','Skontaktuj się z pomocą','Krótkie i praktyczne odpowiedzi.','Potrzebujesz indywidualnej odpowiedzi?'],
    'support_contact'=>['Kontakt','Pytanie bankowe zasługuje na jasną odpowiedź.','Opisz sprawę dotyczącą wsparcia, konta, partnerstwa, prasy lub administracji.','Napisz do wsparcia','Formularz przyspieszający obsługę.','Czy Twoja prośba jest gotowa?'],
    'support_security'=>['Bezpieczeństwo bankowe','Bezpieczeństwo musi być widoczne na każdym etapie.','Zuider Bank S.A chroni dostęp, wrażliwe operacje i weryfikowalne dowody.','Otwórz bezpieczne konto','Bezpieczeństwo do realnego użycia.','Zabezpiecz operacje widocznymi dowodami.'],
    'support_legal'=>['Informacje prawne','Czytelne ramy prawne dla korzystania z Zuider Bank S.A.','Informacje o wydawcy, użyciu strony, danych i odpowiedzialności.','Skontaktuj się z Zuider Bank S.A','Zgodność zaczyna się od zrozumiałych informacji.','Pytanie o kwestie prawne?'],
];
foreach ($t as $key => $v) { $data['pages'][$key]['eyebrow']=$v[0]; $data['pages'][$key]['title']=$v[1]; $data['pages'][$key]['subtitle']=$v[2]; $data['pages'][$key]['primary_cta']=$v[3]; $data['pages'][$key]['hero_card_title']=$v[4]; $data['pages'][$key]['cta_title']=$v[5]; }
$localizePublicPages = require __DIR__ . '/../public_pages_localizer.php';
return $localizePublicPages($data, 'pl');
