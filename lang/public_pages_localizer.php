<?php

return function (array $data, string $locale): array {
    $translations = [
        'en' => [
            'cards_kicker' => 'Benefits',
            'cards_intro' => 'A structure designed to make each piece of information clear, useful and immediately actionable.',
            'cards' => [
                ['title' => 'Immediate clarity', 'text' => 'Prioritized information to understand quickly, decide calmly and keep a clear view.', 'items' => ['Readable interface', 'Useful data', 'Clean tracking']],
                ['title' => 'Visible security', 'text' => 'Journeys designed to protect access, sensitive operations and important documents.', 'items' => ['Secure access', 'Available proofs', 'Consistent controls']],
                ['title' => 'Usable proof', 'text' => 'Receipts, documents and structured information for accounting and administration needs.', 'items' => ['PDF receipts', 'Clear history', 'Simple archiving']],
            ],
            'steps_kicker' => 'Method',
            'steps_intro' => 'A simple, serious journey designed to reduce hesitation.',
            'steps' => [
                ['title' => 'Understand the need', 'text' => 'The page first presents the essential information to avoid uncertainty.'],
                ['title' => 'Act methodically', 'text' => 'Each journey highlights useful actions without unnecessary complexity.'],
                ['title' => 'Track the proof', 'text' => 'Important operations remain linked to usable references and documents.'],
                ['title' => 'Get support', 'text' => 'Support remains available when the situation requires a personalized answer.'],
            ],
            'faq' => [
                ['question' => 'Who is this page for?', 'answer' => 'For clients who want to quickly understand the service, its advantages and the steps to follow.'],
                ['question' => 'Is the information kept up to date?', 'answer' => 'Yes. Content evolves with the services and the Zuider Bank S.A experience.'],
                ['question' => 'Can I contact an advisor?', 'answer' => 'Yes. The contact form lets you send a detailed request to the right team.'],
                ['question' => 'Why this approach?', 'answer' => 'Because a modern bank must be clear, secure and useful from the first read.'],
            ],
            'cta_text' => 'Move to a clearer, more modern and better structured banking experience with Zuider Bank S.A.',
            'legal_kicker' => 'Official framework',
            'legal_title' => 'Detailed legal information',
            'legal_intro' => 'Important information is grouped for simple and transparent reading.',
            'page_overrides' => [
                'about_story' => [
                    'cards_title' => 'Banking modernity must inspire trust.',
                    'steps_title' => 'Progress designed to last.',
                ],
            ],
            'contact' => ['kicker' => 'Secure form', 'title' => 'Send your request to Zuider Bank S.A.', 'intro' => 'The form keeps fields compatible with the existing handling process.', 'cards' => [['icon' => 'fas fa-envelope', 'title' => 'Support email', 'text' => 'support@zuiderbank.com for general requests.'], ['icon' => 'fas fa-building', 'title' => 'Business requests', 'text' => 'Accounts, cards, treasury or banking operations.']]],
            'legal_items' => [['title' => 'Website publisher', 'text' => 'The website is published by Zuider Bank S.A.'], ['title' => 'Purpose of the website', 'text' => 'The website presents Zuider Bank S.A digital banking services.'], ['title' => 'Personal data', 'text' => 'Data is used to manage accounts, secure access and process requests.']],
        ],
        'de' => [
            'cards_kicker' => 'Vorteile',
            'cards_intro' => 'Eine Struktur, die jede Information klar, nützlich und direkt verwertbar macht.',
            'cards' => [
                ['title' => 'Sofortige Klarheit', 'text' => 'Priorisierte Informationen, um schnell zu verstehen, ruhig zu entscheiden und den Überblick zu behalten.', 'items' => ['Lesbare Oberfläche', 'Nützliche Daten', 'Saubere Nachverfolgung']],
                ['title' => 'Sichtbare Sicherheit', 'text' => 'Abläufe zum Schutz von Zugängen, sensiblen Vorgängen und wichtigen Dokumenten.', 'items' => ['Sicherer Zugang', 'Verfügbare Nachweise', 'Stimmige Kontrollen']],
                ['title' => 'Nutzbare Nachweise', 'text' => 'Belege, Dokumente und strukturierte Informationen für Buchhaltung und Verwaltung.', 'items' => ['PDF-Belege', 'Klare Historie', 'Einfache Archivierung']],
            ],
            'steps_kicker' => 'Methode',
            'steps_intro' => 'Ein einfacher, seriöser Ablauf, der Unsicherheit reduziert.',
            'steps' => [
                ['title' => 'Bedarf verstehen', 'text' => 'Die Seite zeigt zuerst die wichtigsten Informationen, um Unklarheiten zu vermeiden.'],
                ['title' => 'Methodisch handeln', 'text' => 'Jeder Ablauf hebt sinnvolle Aktionen hervor, ohne unnötige Komplexität.'],
                ['title' => 'Nachweise verfolgen', 'text' => 'Wichtige Vorgänge bleiben mit nutzbaren Referenzen und Dokumenten verbunden.'],
                ['title' => 'Begleitung erhalten', 'text' => 'Der Support bleibt verfügbar, wenn die Situation eine persönliche Antwort erfordert.'],
            ],
            'faq' => [
                ['question' => 'Für wen ist diese Seite gedacht?', 'answer' => 'Für Kundinnen und Kunden, die den Service, seine Vorteile und die nächsten Schritte schnell verstehen möchten.'],
                ['question' => 'Werden die Informationen aktualisiert?', 'answer' => 'Ja. Die Inhalte entwickeln sich mit den Services und der Erfahrung von Zuider Bank S.A weiter.'],
                ['question' => 'Kann ich einen Berater kontaktieren?', 'answer' => 'Ja. Über das Kontaktformular senden Sie eine detaillierte Anfrage an das passende Team.'],
                ['question' => 'Warum dieser Ansatz?', 'answer' => 'Weil eine moderne Bank ab der ersten Lektüre klar, sicher und nützlich sein muss.'],
            ],
            'cta_text' => 'Wechseln Sie zu einem klareren, moderneren und besser strukturierten Bankerlebnis mit Zuider Bank S.A.',
            'legal_kicker' => 'Offizieller Rahmen',
            'legal_title' => 'Detaillierte rechtliche Informationen',
            'legal_intro' => 'Wichtige Informationen sind für eine einfache und transparente Lektüre zusammengefasst.',
            'page_overrides' => [
                'about_story' => [
                    'cards_title' => 'Moderne Bankdienstleistungen müssen Vertrauen schaffen.',
                    'steps_title' => 'Ein Fortschritt, der auf Dauer ausgelegt ist.',
                ],
            ],
            'contact' => ['kicker' => 'Sicheres Formular', 'title' => 'Senden Sie Ihre Anfrage an Zuider Bank S.A.', 'intro' => 'Das Formular behält Felder bei, die mit der bestehenden Bearbeitung kompatibel sind.', 'cards' => [['icon' => 'fas fa-envelope', 'title' => 'Support-E-Mail', 'text' => 'support@zuiderbank.com für allgemeine Anfragen.'], ['icon' => 'fas fa-building', 'title' => 'Geschäftsanfragen', 'text' => 'Konten, Karten, Treasury oder Bankgeschäfte.']]],
            'legal_items' => [['title' => 'Herausgeber der Website', 'text' => 'Die Website wird von Zuider Bank S.A herausgegeben.'], ['title' => 'Zweck der Website', 'text' => 'Die Website präsentiert die digitalen Bankdienstleistungen von Zuider Bank S.A.'], ['title' => 'Personenbezogene Daten', 'text' => 'Daten werden zur Kontoverwaltung, Zugangssicherung und Bearbeitung von Anfragen verwendet.']],
        ],
        'nl' => [
            'cards_kicker' => 'Voordelen',
            'cards_intro' => 'Een structuur die elke informatie duidelijk, nuttig en direct bruikbaar maakt.',
            'cards' => [
                ['title' => 'Directe duidelijkheid', 'text' => 'Geordende informatie om snel te begrijpen, rustig te beslissen en overzicht te houden.', 'items' => ['Leesbare interface', 'Nuttige gegevens', 'Heldere opvolging']],
                ['title' => 'Zichtbare veiligheid', 'text' => 'Trajecten ontworpen om toegang, gevoelige handelingen en belangrijke documenten te beschermen.', 'items' => ['Veilige toegang', 'Beschikbare bewijzen', 'Samenhangende controles']],
                ['title' => 'Bruikbare bewijzen', 'text' => 'Bewijzen, documenten en gestructureerde informatie voor boekhouding en administratie.', 'items' => ['PDF-bewijzen', 'Duidelijke historie', 'Eenvoudig archief']],
            ],
            'steps_kicker' => 'Methode',
            'steps_intro' => 'Een eenvoudig en ernstig traject dat twijfel vermindert.',
            'steps' => [
                ['title' => 'De behoefte begrijpen', 'text' => 'De pagina toont eerst de essentiële informatie om onduidelijkheid te vermijden.'],
                ['title' => 'Methodisch handelen', 'text' => 'Elk traject benadrukt nuttige acties zonder overbodige complexiteit.'],
                ['title' => 'Bewijzen opvolgen', 'text' => 'Belangrijke verrichtingen blijven gekoppeld aan bruikbare referenties en documenten.'],
                ['title' => 'Begeleiding krijgen', 'text' => 'Support blijft beschikbaar wanneer de situatie een persoonlijk antwoord vraagt.'],
            ],
            'faq' => [
                ['question' => 'Voor wie is deze pagina bedoeld?', 'answer' => 'Voor klanten die de dienst, voordelen en volgende stappen snel willen begrijpen.'],
                ['question' => 'Wordt de informatie bijgewerkt?', 'answer' => 'Ja. De inhoud evolueert met de diensten en de ervaring van Zuider Bank S.A.'],
                ['question' => 'Kan ik een adviseur contacteren?', 'answer' => 'Ja. Via het contactformulier stuurt u een gedetailleerde aanvraag naar het juiste team.'],
                ['question' => 'Waarom deze aanpak?', 'answer' => 'Omdat een moderne bank vanaf de eerste lezing duidelijk, veilig en nuttig moet zijn.'],
            ],
            'cta_text' => 'Stap over naar een duidelijkere, modernere en beter gestructureerde bankervaring met Zuider Bank S.A.',
            'legal_kicker' => 'Officieel kader',
            'legal_title' => 'Gedetailleerde juridische informatie',
            'legal_intro' => 'Belangrijke informatie is gegroepeerd voor een eenvoudige en transparante lezing.',
            'page_overrides' => [
                'about_story' => [
                    'cards_title' => 'Moderne bankdiensten moeten vertrouwen wekken.',
                    'steps_title' => 'Vooruitgang ontworpen om lang mee te gaan.',
                ],
            ],
            'contact' => ['kicker' => 'Beveiligd formulier', 'title' => 'Stuur uw aanvraag naar Zuider Bank S.A.', 'intro' => 'Het formulier behoudt velden die compatibel zijn met de bestaande verwerking.', 'cards' => [['icon' => 'fas fa-envelope', 'title' => 'Support e-mail', 'text' => 'support@zuiderbank.com voor algemene aanvragen.'], ['icon' => 'fas fa-building', 'title' => 'Professionele aanvragen', 'text' => 'Rekeningen, kaarten, treasury of bankverrichtingen.']]],
            'legal_items' => [['title' => 'Uitgever van de website', 'text' => 'De website wordt uitgegeven door Zuider Bank S.A.'], ['title' => 'Doel van de website', 'text' => 'De website presenteert de digitale bankdiensten van Zuider Bank S.A.'], ['title' => 'Persoonsgegevens', 'text' => 'Gegevens worden gebruikt om rekeningen te beheren, toegang te beveiligen en aanvragen te verwerken.']],
        ],
        'es' => [
            'cards_kicker' => 'Beneficios',
            'cards_intro' => 'Una estructura pensada para que cada información sea clara, útil y directamente accionable.',
            'cards' => [
                ['title' => 'Claridad inmediata', 'text' => 'Información jerarquizada para entender rápido, decidir con calma y mantener una visión clara.', 'items' => ['Interfaz legible', 'Datos útiles', 'Seguimiento limpio']],
                ['title' => 'Seguridad visible', 'text' => 'Recorridos diseñados para proteger accesos, operaciones sensibles y documentos importantes.', 'items' => ['Acceso seguro', 'Pruebas disponibles', 'Controles coherentes']],
                ['title' => 'Pruebas utilizables', 'text' => 'Justificantes, documentos e información estructurada para contabilidad y administración.', 'items' => ['Recibos PDF', 'Historial claro', 'Archivo simple']],
            ],
            'steps_kicker' => 'Método',
            'steps_intro' => 'Un recorrido simple, serio y diseñado para reducir dudas.',
            'steps' => [
                ['title' => 'Entender la necesidad', 'text' => 'La página presenta primero la información esencial para evitar zonas de duda.'],
                ['title' => 'Actuar con método', 'text' => 'Cada recorrido destaca acciones útiles sin complejidad innecesaria.'],
                ['title' => 'Seguir las pruebas', 'text' => 'Las operaciones importantes quedan asociadas a referencias y documentos utilizables.'],
                ['title' => 'Recibir apoyo', 'text' => 'El soporte sigue disponible cuando la situación requiere una respuesta personalizada.'],
            ],
            'faq' => [
                ['question' => '¿A quién va dirigida esta página?', 'answer' => 'A clientes que quieren entender rápidamente el servicio, sus ventajas y los pasos a seguir.'],
                ['question' => '¿La información se actualiza?', 'answer' => 'Sí. Los contenidos evolucionan con los servicios y la experiencia Zuider Bank S.A.'],
                ['question' => '¿Puedo contactar con un asesor?', 'answer' => 'Sí. El formulario de contacto permite enviar una solicitud detallada al equipo adecuado.'],
                ['question' => '¿Por qué este enfoque?', 'answer' => 'Porque un banco moderno debe ser claro, seguro y útil desde la primera lectura.'],
            ],
            'cta_text' => 'Pase a una experiencia bancaria más clara, moderna y mejor estructurada con Zuider Bank S.A.',
            'legal_kicker' => 'Marco oficial',
            'legal_title' => 'Información legal detallada',
            'legal_intro' => 'La información importante se agrupa para una lectura simple y transparente.',
            'page_overrides' => [
                'about_story' => [
                    'cards_title' => 'La modernidad bancaria debe inspirar confianza.',
                    'steps_title' => 'Una evolución pensada para perdurar.',
                ],
            ],
            'contact' => ['kicker' => 'Formulario seguro', 'title' => 'Envíe su solicitud a Zuider Bank S.A.', 'intro' => 'El formulario conserva campos compatibles con el tratamiento existente.', 'cards' => [['icon' => 'fas fa-envelope', 'title' => 'Email de soporte', 'text' => 'support@zuiderbank.com para solicitudes generales.'], ['icon' => 'fas fa-building', 'title' => 'Solicitudes profesionales', 'text' => 'Cuentas, tarjetas, tesorería u operaciones bancarias.']]],
            'legal_items' => [['title' => 'Editor del sitio', 'text' => 'El sitio es editado por Zuider Bank S.A.'], ['title' => 'Objeto del sitio', 'text' => 'El sitio presenta los servicios bancarios digitales de Zuider Bank S.A.'], ['title' => 'Datos personales', 'text' => 'Los datos sirven para gestionar cuentas, proteger accesos y tratar solicitudes.']],
        ],
        'pl' => [
            'cards_kicker' => 'Korzyści',
            'cards_intro' => 'Struktura zaprojektowana tak, aby każda informacja była jasna, użyteczna i od razu praktyczna.',
            'cards' => [
                ['title' => 'Natychmiastowa przejrzystość', 'text' => 'Uporządkowane informacje pomagają szybko zrozumieć, spokojnie zdecydować i zachować kontrolę.', 'items' => ['Czytelny interfejs', 'Użyteczne dane', 'Czyste śledzenie']],
                ['title' => 'Widoczne bezpieczeństwo', 'text' => 'Ścieżki chroniące dostęp, wrażliwe operacje i ważne dokumenty.', 'items' => ['Bezpieczny dostęp', 'Dostępne potwierdzenia', 'Spójne kontrole']],
                ['title' => 'Użyteczne potwierdzenia', 'text' => 'Potwierdzenia, dokumenty i uporządkowane informacje dla księgowości i administracji.', 'items' => ['Potwierdzenia PDF', 'Czytelna historia', 'Proste archiwum']],
            ],
            'steps_kicker' => 'Metoda',
            'steps_intro' => 'Prosta i poważna ścieżka zaprojektowana, aby zmniejszać niepewność.',
            'steps' => [
                ['title' => 'Zrozumieć potrzebę', 'text' => 'Strona najpierw pokazuje kluczowe informacje, aby uniknąć niejasności.'],
                ['title' => 'Działać metodycznie', 'text' => 'Każda ścieżka podkreśla użyteczne działania bez zbędnej złożoności.'],
                ['title' => 'Śledzić dowody', 'text' => 'Ważne operacje pozostają powiązane z użytecznymi referencjami i dokumentami.'],
                ['title' => 'Otrzymać wsparcie', 'text' => 'Wsparcie pozostaje dostępne, gdy sytuacja wymaga indywidualnej odpowiedzi.'],
            ],
            'faq' => [
                ['question' => 'Dla kogo jest ta strona?', 'answer' => 'Dla klientów, którzy chcą szybko zrozumieć usługę, jej zalety i kolejne kroki.'],
                ['question' => 'Czy informacje są aktualizowane?', 'answer' => 'Tak. Treści rozwijają się wraz z usługami i doświadczeniem Zuider Bank S.A.'],
                ['question' => 'Czy mogę skontaktować się z doradcą?', 'answer' => 'Tak. Formularz kontaktowy pozwala wysłać szczegółowe zgłoszenie do właściwego zespołu.'],
                ['question' => 'Dlaczego takie podejście?', 'answer' => 'Ponieważ nowoczesny bank powinien być jasny, bezpieczny i użyteczny od pierwszego kontaktu.'],
            ],
            'cta_text' => 'Przejdź na jaśniejsze, nowocześniejsze i lepiej uporządkowane doświadczenie bankowe z Zuider Bank S.A.',
            'legal_kicker' => 'Ramy oficjalne',
            'legal_title' => 'Szczegółowe informacje prawne',
            'legal_intro' => 'Ważne informacje zebrano w jednym miejscu, aby były proste i przejrzyste.',
            'page_overrides' => [
                'about_story' => [
                    'cards_title' => 'Nowoczesna bankowość musi budzić zaufanie.',
                    'steps_title' => 'Rozwój zaprojektowany na lata.',
                ],
            ],
            'contact' => ['kicker' => 'Bezpieczny formularz', 'title' => 'Wyślij zgłoszenie do Zuider Bank S.A.', 'intro' => 'Formularz zachowuje pola zgodne z obecnym procesem obsługi.', 'cards' => [['icon' => 'fas fa-envelope', 'title' => 'Email wsparcia', 'text' => 'support@zuiderbank.com dla ogólnych zapytań.'], ['icon' => 'fas fa-building', 'title' => 'Zapytania biznesowe', 'text' => 'Konta, karty, treasury lub operacje bankowe.']]],
            'legal_items' => [['title' => 'Wydawca strony', 'text' => 'Strona jest wydawana przez Zuider Bank S.A.'], ['title' => 'Cel strony', 'text' => 'Strona prezentuje cyfrowe usługi bankowe Zuider Bank S.A.'], ['title' => 'Dane osobowe', 'text' => 'Dane służą do zarządzania kontami, zabezpieczania dostępu i obsługi zgłoszeń.']],
        ],
        'it' => [
            'cards_kicker' => 'Vantaggi',
            'cards_intro' => 'Una struttura pensata per rendere ogni informazione chiara, utile e subito utilizzabile.',
            'cards' => [
                ['title' => 'Chiarezza immediata', 'text' => 'Informazioni ordinate per capire rapidamente, decidere con calma e mantenere una visione chiara.', 'items' => ['Interfaccia leggibile', 'Dati utili', 'Monitoraggio pulito']],
                ['title' => 'Sicurezza visibile', 'text' => 'Percorsi progettati per proteggere accessi, operazioni sensibili e documenti importanti.', 'items' => ['Accesso sicuro', 'Prove disponibili', 'Controlli coerenti']],
                ['title' => 'Prove utilizzabili', 'text' => 'Ricevute, documenti e informazioni strutturate per esigenze contabili e amministrative.', 'items' => ['Ricevute PDF', 'Storico chiaro', 'Archivio semplice']],
            ],
            'steps_kicker' => 'Metodo',
            'steps_intro' => 'Un percorso semplice, serio e progettato per ridurre le esitazioni.',
            'steps' => [
                ['title' => 'Capire il bisogno', 'text' => 'La pagina presenta prima le informazioni essenziali per evitare zone d’ombra.'],
                ['title' => 'Agire con metodo', 'text' => 'Ogni percorso mette in evidenza le azioni utili, senza complessità inutile.'],
                ['title' => 'Seguire le prove', 'text' => 'Le operazioni importanti restano collegate a riferimenti e documenti utilizzabili.'],
                ['title' => 'Essere accompagnati', 'text' => 'Il supporto resta disponibile quando la situazione richiede una risposta personalizzata.'],
            ],
            'faq' => [
                ['question' => 'A chi è rivolta questa pagina?', 'answer' => 'Ai clienti che vogliono capire rapidamente il servizio, i vantaggi e i passaggi da seguire.'],
                ['question' => 'Le informazioni sono aggiornate?', 'answer' => 'Sì. I contenuti evolvono con i servizi e l’esperienza Zuider Bank S.A.'],
                ['question' => 'Posso contattare un consulente?', 'answer' => 'Sì. Il modulo di contatto consente di inviare una richiesta dettagliata al team corretto.'],
                ['question' => 'Perché questo approccio?', 'answer' => 'Perché una banca moderna deve essere chiara, sicura e utile fin dalla prima lettura.'],
            ],
            'cta_text' => 'Passa a un’esperienza bancaria più chiara, moderna e meglio strutturata con Zuider Bank S.A.',
            'legal_kicker' => 'Quadro ufficiale',
            'legal_title' => 'Informazioni legali dettagliate',
            'legal_intro' => 'Le informazioni importanti sono raggruppate per una lettura semplice e trasparente.',
            'page_overrides' => [
                'about_story' => [
                    'cards_title' => 'La modernità bancaria deve ispirare fiducia.',
                    'steps_title' => 'Un progresso pensato per durare.',
                ],
            ],
            'contact' => ['kicker' => 'Modulo sicuro', 'title' => 'Invia la tua richiesta a Zuider Bank S.A.', 'intro' => 'Il modulo conserva campi compatibili con il processo di gestione esistente.', 'cards' => [['icon' => 'fas fa-envelope', 'title' => 'Email supporto', 'text' => 'support@zuiderbank.com per richieste generali.'], ['icon' => 'fas fa-building', 'title' => 'Richieste professionali', 'text' => 'Conti, carte, tesoreria o operazioni bancarie.']]],
            'legal_items' => [['title' => 'Editore del sito', 'text' => 'Il sito è pubblicato da Zuider Bank S.A.'], ['title' => 'Oggetto del sito', 'text' => 'Il sito presenta i servizi bancari digitali di Zuider Bank S.A.'], ['title' => 'Dati personali', 'text' => 'I dati servono a gestire conti, proteggere accessi e trattare richieste.']],
        ],
    ];

    if (!isset($translations[$locale])) {
        return $data;
    }

    $common = $translations[$locale];

    foreach ($data['pages'] as $key => $page) {
        $data['pages'][$key]['cards_kicker'] = $common['cards_kicker'];
        $data['pages'][$key]['cards_intro'] = $common['cards_intro'];
        $data['pages'][$key]['cards'] = array_map(function (array $card, int $index) use ($common) {
            return array_merge($card, $common['cards'][$index]);
        }, $page['cards'] ?? [], array_keys($page['cards'] ?? []));

        $data['pages'][$key]['steps_kicker'] = $common['steps_kicker'];
        $data['pages'][$key]['steps_intro'] = $common['steps_intro'];
        $data['pages'][$key]['steps'] = $common['steps'];
        $data['pages'][$key]['faq'] = $common['faq'];
        $data['pages'][$key]['cta_text'] = $common['cta_text'];

        $data['pages'][$key]['legal_kicker'] = $common['legal_kicker'];
        $data['pages'][$key]['legal_title'] = $common['legal_title'];
        $data['pages'][$key]['legal_intro'] = $common['legal_intro'];
    }

    foreach (($common['page_overrides'] ?? []) as $pageKey => $overrides) {
        if (isset($data['pages'][$pageKey])) {
            $data['pages'][$pageKey] = array_merge($data['pages'][$pageKey], $overrides);
        }
    }

    if (isset($data['pages']['support_contact'])) {
        $data['pages']['support_contact']['contact'] = $common['contact'];
    }

    if (isset($data['pages']['support_legal'])) {
        $data['pages']['support_legal']['legal_items'] = $common['legal_items'];
    }

    return $data;
};
