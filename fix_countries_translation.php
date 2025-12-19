<?php

/**
 * Script pour traduire tous les pays restants dans register.blade.php
 */

$registerFile = __DIR__ . '/resources/views/auth/register.blade.php';

if (!file_exists($registerFile)) {
    die("❌ Fichier register.blade.php non trouvé!\n");
}

$content = file_get_contents($registerFile);

// Traductions des pays restants
$countryTranslations = [
    ">(DE) Allemagne<" => ">{{ __('auth.country_germany') }}<",
    ">(AT) Autriche<" => ">{{ __('auth.country_austria') }}<",
    ">(BE) Belgique<" => ">{{ __('auth.country_belgium') }}<",
    ">(BG) Bulgarie<" => ">{{ __('auth.country_bulgaria') }}<",
    ">(CY) Chypre<" => ">{{ __('auth.country_cyprus') }}<",
    ">(HR) Croatie<" => ">{{ __('auth.country_croatia') }}<",
    ">(DK) Danemark<" => ">{{ __('auth.country_denmark') }}<",
    ">(ES) Espagne<" => ">{{ __('auth.country_spain') }}<",
    ">(EE) Estonie<" => ">{{ __('auth.country_estonia') }}<",
    ">(FI) Finlande<" => ">{{ __('auth.country_finland') }}<",
    ">(GR) Grèce<" => ">{{ __('auth.country_greece') }}<",
    ">(HU) Hongrie<" => ">{{ __('auth.country_hungary') }}<",
    ">(IE) Irlande<" => ">{{ __('auth.country_ireland') }}<",
    ">(IT) Italie<" => ">{{ __('auth.country_italy') }}<",
    ">(LV) Lettonie<" => ">{{ __('auth.country_latvia') }}<",
    ">(LT) Lituanie<" => ">{{ __('auth.country_lithuania') }}<",
    ">(LU) Luxembourg<" => ">{{ __('auth.country_luxembourg') }}<",
    ">(MT) Malte<" => ">{{ __('auth.country_malta') }}<",
    ">(NL) Pays-Bas<" => ">{{ __('auth.country_netherlands') }}<",
    ">(PL) Pologne<" => ">{{ __('auth.country_poland') }}<",
    ">(PT) Portugal<" => ">{{ __('auth.country_portugal') }}<",
    ">(CZ) République Tchèque<" => ">{{ __('auth.country_czech') }}<",
    ">(RO) Roumanie<" => ">{{ __('auth.country_romania') }}<",
    ">(SK) Slovaquie<" => ">{{ __('auth.country_slovakia') }}<",
    ">(SI) Slovénie<" => ">{{ __('auth.country_slovenia') }}<",
    ">(SE) Suède<" => ">{{ __('auth.country_sweden') }}<",
    ">(CH) Suisse<" => ">{{ __('auth.country_switzerland') }}<",
    ">(NO) Norvège<" => ">{{ __('auth.country_norway') }}<",
    ">(IS) Islande<" => ">{{ __('auth.country_iceland') }}<",
    ">(GB) Royaume-Uni<" => ">{{ __('auth.country_uk') }}<",
    ">(AL) Albanie<" => ">{{ __('auth.country_albania') }}<",
    ">(BA) Bosnie-Herzégovine<" => ">{{ __('auth.country_bosnia') }}<",
    ">(RS) Serbie<" => ">{{ __('auth.country_serbia') }}<",
    ">(ME) Monténégro<" => ">{{ __('auth.country_montenegro') }}<",
    ">(MK) Macédoine du Nord<" => ">{{ __('auth.country_macedonia') }}<",
    ">(XK) Kosovo<" => ">{{ __('auth.country_kosovo') }}<",
    ">(AD) Andorre<" => ">{{ __('auth.country_andorra') }}<",
    ">(LI) Liechtenstein<" => ">{{ __('auth.country_liechtenstein') }}<",
    ">(MC) Monaco<" => ">{{ __('auth.country_monaco') }}<",
    ">(SM) Saint-Marin<" => ">{{ __('auth.country_san_marino') }}<",
    ">(VA) Vatican<" => ">{{ __('auth.country_vatican') }}<",
    ">Canada<" => ">{{ __('auth.country_canada') }}<",
    ">Autre<" => ">{{ __('auth.country_other') }}<",
];

// Appliquer les traductions
$count = 0;
foreach ($countryTranslations as $search => $replace) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        $count++;
    }
}

// Sauvegarder le fichier
file_put_contents($registerFile, $content);

echo "✅ Traduction des pays complétée!\n";
echo "📊 Nombre de pays traduits: $count\n";
echo "📝 Fichier mis à jour: $registerFile\n";
