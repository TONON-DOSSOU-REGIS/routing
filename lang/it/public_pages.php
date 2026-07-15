<?php
$data = require __DIR__ . '/../fr/public_pages.php';
$data['shared'] = [
    'nav_home'=>'Home','nav_services'=>'Servizi','nav_about'=>'Chi siamo','nav_support'=>'Supporto','client_area'=>'Area cliente','open_account'=>'Apri un conto',
    'first_name'=>'Nome','last_name'=>'Cognome','email'=>'Indirizzo email','phone'=>'Telefono','subject'=>'Oggetto','choose_subject'=>'Scegli un oggetto',
    'subject_support'=>'Supporto clienti','subject_commercial'=>'Apertura conto','subject_partnership'=>'Partnership','subject_press'=>'Stampa','subject_other'=>'Altra richiesta',
    'message'=>'Messaggio','message_placeholder'=>'Spiegaci la tua esigenza. Risponderemo con informazioni chiare e utili.',
    'privacy_notice'=>'Accetto che Zuider Bank S.A utilizzi queste informazioni per rispondere alla mia richiesta.','send_request'=>'Invia la richiesta','rights'=>'Tutti i diritti riservati.',
];
$t = [
    'services_business'=>['Conto professionale','Un conto professionale per decidere rapidamente, pagare con chiarezza e mantenere il controllo.','Uno spazio bancario chiaro e sicuro per operazioni quotidiane e decisioni sensibili.','Crea il mio conto professionale','Una base bancaria solida per la tua attività.','Costruisci la tua base bancaria professionale.'],
    'services_international'=>['Pagamenti internazionali','Bonifici internazionali tracciati, documentati e comprensibili.','I trasferimenti mantengono una traccia chiara prima, durante e dopo il trattamento.','Preparare un bonifico','Ogni trasferimento mantiene una traccia chiara.','Invia bonifici internazionali con più visibilità.'],
    'services_treasury'=>['Gestione tesoreria','Una tesoreria leggibile rapidamente e gestita con calma.','Saldo, storico, documenti e avvisi diventano più facili da usare.','Gestisci la tesoreria','La chiarezza finanziaria diventa un vantaggio.','Trasforma il conto in uno strumento di controllo.'],
    'services_cards'=>['Carte di pagamento','Carte moderne per pagare, seguire e giustificare.','Una carta bancaria seria collegata a un’esperienza chiara e sicura.','Richiedi la carta','Una carta è utile solo se resta controllabile.','Dai ai tuoi pagamenti una carta all’altezza.'],
    'about_story'=>['La nostra storia','Una banca creata per riportare chiarezza nella finanza digitale.','Zuider Bank S.A modernizza la banca senza perdere serietà.','Apri il mio spazio','Fiducia, chiarezza e sicurezza.','Scopri una banca che avanza con metodo.'],
    'about_careers'=>['Carriere','Costruisci una banca più chiara, sicura e umana.','Cerchiamo profili che amano prodotti ben fatti e decisioni responsabili.','Invia candidatura','Un team che preferisce precisione al rumore.','Vuoi costruire una banca più chiara?'],
    'about_press'=>['Stampa e media','Risorse stampa per capire l’evoluzione di Zuider Bank S.A.','Trova posizionamento, temi chiave e informazioni ufficiali.','Contatta la stampa','Una banca digitale che assume la propria serietà.','Hai bisogno di informazioni stampa affidabili?'],
    'about_blog'=>['Blog bancario','Articoli per capire meglio la banca online.','Guide su sicurezza, bonifici, ricevute, carte e tesoreria.','Apri il mio conto','Letture utili per decidere meglio.','Passa dalla lettura all’azione.'],
    'support_help'=>['Centro assistenza','Un centro assistenza per trovare risposte, non per perdersi.','Risposte essenziali su conto, sicurezza, bonifici e ricevute.','Contatta il supporto','Risposte brevi, utili e orientate all’azione.','Serve una risposta personalizzata?'],
    'support_contact'=>['Contatti','Una domanda bancaria merita una risposta chiara.','Descrivi la richiesta: supporto, conto, partnership, stampa o amministrazione.','Scrivi al supporto','Un modulo pensato per accelerare il trattamento.','La tua richiesta è pronta?'],
    'support_security'=>['Sicurezza bancaria','La sicurezza deve essere visibile in ogni passaggio.','Zuider Bank S.A protegge accessi, operazioni sensibili e prove verificabili.','Apri un conto sicuro','Sicurezza pensata per l’uso reale.','Proteggi le operazioni con prove visibili.'],
    'support_legal'=>['Note legali','Un quadro legale leggibile per usare Zuider Bank S.A con fiducia.','Informazioni essenziali su editore, uso del sito, dati e responsabilità.','Contatta Zuider Bank S.A','La conformità inizia da informazioni comprensibili.','Domande sul quadro legale?'],
];
foreach ($t as $key => $v) { $data['pages'][$key]['eyebrow']=$v[0]; $data['pages'][$key]['title']=$v[1]; $data['pages'][$key]['subtitle']=$v[2]; $data['pages'][$key]['primary_cta']=$v[3]; $data['pages'][$key]['hero_card_title']=$v[4]; $data['pages'][$key]['cta_title']=$v[5]; }
$localizePublicPages = require __DIR__ . '/../public_pages_localizer.php';
return $localizePublicPages($data, 'it');
