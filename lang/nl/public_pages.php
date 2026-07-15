<?php
$data = require __DIR__ . '/../fr/public_pages.php';
$data['shared'] = [
    'nav_home'=>'Home','nav_services'=>'Diensten','nav_about'=>'Over ons','nav_support'=>'Support','client_area'=>'Klantenzone','open_account'=>'Rekening openen',
    'first_name'=>'Voornaam','last_name'=>'Achternaam','email'=>'E-mailadres','phone'=>'Telefoon','subject'=>'Onderwerp','choose_subject'=>'Kies een onderwerp',
    'subject_support'=>'Klantenservice','subject_commercial'=>'Rekening openen','subject_partnership'=>'Partnerschap','subject_press'=>'Pers','subject_other'=>'Andere aanvraag',
    'message'=>'Bericht','message_placeholder'=>'Vertel ons wat u nodig hebt. Wij antwoorden met duidelijke en bruikbare informatie.',
    'privacy_notice'=>'Ik ga ermee akkoord dat Zuider Bank S.A deze informatie gebruikt om mijn aanvraag te beantwoorden.','send_request'=>'Mijn aanvraag verzenden','rights'=>'Alle rechten voorbehouden.',
];
$t = [
    'services_business'=>['Zakelijke rekening','Een zakelijke rekening voor snelle beslissingen, duidelijke betalingen en controle.','Een heldere en veilige bankruimte voor dagelijkse en gevoelige handelingen.','Mijn zakelijke rekening maken','Een stevige bankbasis voor uw activiteit.','Bouw uw professionele bankbasis.'],
    'services_international'=>['Internationale betalingen','Internationale overschrijvingen die gevolgd, gedocumenteerd en begrijpelijk zijn.','Uw transfers blijven duidelijk vóór, tijdens en na verwerking.','Overschrijving voorbereiden','Elke transfer houdt een helder spoor.','Verstuur internationale betalingen met meer zichtbaarheid.'],
    'services_treasury'=>['Treasurybeheer','Treasury die snel leesbaar en rustig bestuurbaar is.','Saldo, historiek, documenten en signalen worden bruikbaarder.','Mijn treasury beheren','Financiële duidelijkheid wordt een voordeel.','Maak van uw rekening een stuurinstrument.'],
    'services_cards'=>['Betaalkaarten','Moderne kaarten om te betalen, volgen en verantwoorden.','Een serieuze bankkaart gekoppeld aan een duidelijke en veilige ervaring.','Mijn kaart aanvragen','Een kaart is nuttig als ze controleerbaar blijft.','Geef uw betalingen een passende kaart.'],
    'about_story'=>['Ons verhaal','Een bank gebouwd om duidelijkheid terug te brengen in digitale finance.','Zuider Bank S.A moderniseert bankieren zonder ernst te verliezen.','Mijn ruimte openen','Vertrouwen, duidelijkheid en veiligheid.','Ontdek een bank die methodisch vooruitgaat.'],
    'about_careers'=>['Carrières','Bouw mee aan een duidelijkere, veiligere en menselijkere bank.','We zoeken mensen die houden van goede producten en verantwoordelijke beslissingen.','Mijn kandidatuur verzenden','Een team dat precisie verkiest boven ruis.','Wilt u een duidelijkere bank bouwen?'],
    'about_press'=>['Pers en media','Persinformatie over de ontwikkeling van Zuider Bank S.A.','Vind onze positionering, kernonderwerpen en officiële informatie.','Pers contacteren','Een digitale bank met sérieux.','Betrouwbare persinformatie nodig?'],
    'about_blog'=>['Bankblog','Artikelen om online bankieren beter te begrijpen.','Gidsen over veiligheid, overschrijvingen, bewijzen, kaarten en treasury.','Mijn rekening openen','Nuttige lectuur voor betere beslissingen.','Van lezen naar actie.'],
    'support_help'=>['Helpcentrum','Een helpcentrum om antwoorden te vinden, niet om te verdwalen.','Belangrijke antwoorden over rekening, veiligheid, overschrijvingen en bewijzen.','Support contacteren','Korte, nuttige en actiegerichte antwoorden.','Een persoonlijk antwoord nodig?'],
    'support_contact'=>['Contact','Een bankvraag verdient een duidelijk antwoord.','Beschrijf uw vraag over support, rekening, partnerschap, pers of administratie.','Support schrijven','Een formulier voor snellere behandeling.','Is uw aanvraag klaar?'],
    'support_security'=>['Bankveiligheid','Veiligheid moet in elke stap zichtbaar zijn.','Zuider Bank S.A beschermt toegang, gevoelige acties en verifieerbare bewijzen.','Veilige rekening openen','Veiligheid voor echt gebruik.','Beveilig uw acties met zichtbare bewijzen.'],
    'support_legal'=>['Juridische vermeldingen','Een leesbaar juridisch kader voor Zuider Bank S.A.','Essentiële informatie over uitgever, gebruik, gegevens en verantwoordelijkheid.','Zuider Bank S.A contacteren','Naleving begint met begrijpelijke informatie.','Een vraag over het juridisch kader?'],
];
foreach ($t as $key => $v) { $data['pages'][$key]['eyebrow']=$v[0]; $data['pages'][$key]['title']=$v[1]; $data['pages'][$key]['subtitle']=$v[2]; $data['pages'][$key]['primary_cta']=$v[3]; $data['pages'][$key]['hero_card_title']=$v[4]; $data['pages'][$key]['cta_title']=$v[5]; }
$localizePublicPages = require __DIR__ . '/../public_pages_localizer.php';
return $localizePublicPages($data, 'nl');
