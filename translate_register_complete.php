<?php

/**
 * Script pour compléter la traduction de register.blade.php
 * Ce script remplace tous les textes en dur restants par des clés de traduction
 */

$registerFile = __DIR__ . '/resources/views/auth/register.blade.php';

if (!file_exists($registerFile)) {
    die("❌ Fichier register.blade.php non trouvé!\n");
}

$content = file_get_contents($registerFile);

// Traductions à effectuer (texte français => clé de traduction)
$translations = [
    // Pays restants (ceux qui n'ont pas encore été traduits)
    "'(DE) Allemagne'" => "'{{ __(\'auth.country_germany\') }}'",
    "'(AT) Autriche'" => "'{{ __(\'auth.country_austria\') }}'",
    "'(BE) Belgique'" => "'{{ __(\'auth.country_belgium\') }}'",
    "'(BG) Bulgarie'" => "'{{ __(\'auth.country_bulgaria\') }}'",
    "'(CY) Chypre'" => "'{{ __(\'auth.country_cyprus\') }}'",
    "'(HR) Croatie'" => "'{{ __(\'auth.country_croatia\') }}'",
    "'(DK) Danemark'" => "'{{ __(\'auth.country_denmark\') }}'",
    "'(ES) Espagne'" => "'{{ __(\'auth.country_spain\') }}'",
    "'(EE) Estonie'" => "'{{ __(\'auth.country_estonia\') }}'",
    "'(FI) Finlande'" => "'{{ __(\'auth.country_finland\') }}'",
    "'(GR) Grèce'" => "'{{ __(\'auth.country_greece\') }}'",
    "'(HU) Hongrie'" => "'{{ __(\'auth.country_hungary\') }}'",
    "'(IE) Irlande'" => "'{{ __(\'auth.country_ireland\') }}'",
    "'(IT) Italie'" => "'{{ __(\'auth.country_italy\') }}'",
    "'(LV) Lettonie'" => "'{{ __(\'auth.country_latvia\') }}'",
    "'(LT) Lituanie'" => "'{{ __(\'auth.country_lithuania\') }}'",
    "'(LU) Luxembourg'" => "'{{ __(\'auth.country_luxembourg\') }}'",
    "'(MT) Malte'" => "'{{ __(\'auth.country_malta\') }}'",
    "'(NL) Pays-Bas'" => "'{{ __(\'auth.country_netherlands\') }}'",
    "'(PL) Pologne'" => "'{{ __(\'auth.country_poland\') }}'",
    "'(PT) Portugal'" => "'{{ __(\'auth.country_portugal\') }}'",
    "'(CZ) République Tchèque'" => "'{{ __(\'auth.country_czech\') }}'",
    "'(RO) Roumanie'" => "'{{ __(\'auth.country_romania\') }}'",
    "'(SK) Slovaquie'" => "'{{ __(\'auth.country_slovakia\') }}'",
    "'(SI) Slovénie'" => "'{{ __(\'auth.country_slovenia\') }}'",
    "'(SE) Suède'" => "'{{ __(\'auth.country_sweden\') }}'",
    "'(CH) Suisse'" => "'{{ __(\'auth.country_switzerland\') }}'",
    "'(NO) Norvège'" => "'{{ __(\'auth.country_norway\') }}'",
    "'(IS) Islande'" => "'{{ __(\'auth.country_iceland\') }}'",
    "'(GB) Royaume-Uni'" => "'{{ __(\'auth.country_uk\') }}'",
    "'(AL) Albanie'" => "'{{ __(\'auth.country_albania\') }}'",
    "'(BA) Bosnie-Herzégovine'" => "'{{ __(\'auth.country_bosnia\') }}'",
    "'(RS) Serbie'" => "'{{ __(\'auth.country_serbia\') }}'",
    "'(ME) Monténégro'" => "'{{ __(\'auth.country_montenegro\') }}'",
    "'(MK) Macédoine du Nord'" => "'{{ __(\'auth.country_macedonia\') }}'",
    "'(XK) Kosovo'" => "'{{ __(\'auth.country_kosovo\') }}'",
    "'(AD) Andorre'" => "'{{ __(\'auth.country_andorra\') }}'",
    "'(LI) Liechtenstein'" => "'{{ __(\'auth.country_liechtenstein\') }}'",
    "'(MC) Monaco'" => "'{{ __(\'auth.country_monaco\') }}'",
    "'(SM) Saint-Marin'" => "'{{ __(\'auth.country_san_marino\') }}'",
    "'(VA) Vatican'" => "'{{ __(\'auth.country_vatican\') }}'",
    "'>Canada<" => "'>{{ __(\'auth.country_canada\') }}<",
    "'>Autre<" => "'>{{ __(\'auth.country_other\') }}<",
    
    // Autres champs du formulaire
    "'>Ville<" => "'>{{ __(\'auth.city\') }}<",
    "'Paris'" => "'{{ __(\'auth.city_placeholder\') }}'",
    "'>Date de naissance<" => "'>{{ __(\'auth.date_of_birth\') }}<",
    "'>Type de pièce<" => "'>{{ __(\'auth.id_type\') }}<",
    "'Sélectionner'" => "'{{ __(\'auth.id_type_select\') }}'",
    "'>CNI<" => "'>{{ __(\'auth.id_type_cni\') }}<",
    "'>Passeport<" => "'>{{ __(\'auth.id_type_passport\') }}<",
    "'>Permis de conduire<" => "'>{{ __(\'auth.id_type_license\') }}<",
    "'>Numéro de pièce<" => "'>{{ __(\'auth.id_number\') }}<",
    "'Ex: FR1234567'" => "'{{ __(\'auth.id_number_placeholder\') }}'",
    "'>IBAN (optionnel)<" => "'>{{ __(\'auth.iban\') }}<",
    "'FR76 1234 5678 9012 3456 7890 123'" => "'{{ __(\'auth.iban_placeholder\') }}'",
    "'>Mot de passe<" => "'>{{ __(\'auth.password_field\') }}<",
    "'********'" => "'{{ __(\'auth.password_placeholder\') }}'",
    "'>Force du mot de passe<" => "'>{{ __(\'auth.password_strength\') }}<",
    "'>Confirmer le mot de passe<" => "'>{{ __(\'auth.confirm_password\') }}<",
    
    // Conditions et boutons
    "J'accepte les" => "{{ __(\'auth.terms_accept\') }}",
    "conditions d'utilisation" => "{{ __(\'auth.terms_link\') }}",
    " et la" => " {{ __(\'auth.terms_and\') }}",
    "politique de confidentialité" => "{{ __(\'auth.privacy_link\') }}",
    "Créer mon compte" => "{{ __(\'auth.register_button\') }}",
    
    // Footer
    "Tous droits réservés." => "{{ __(\'auth.footer_copyright\') }}",
    "Confidentialité" => "{{ __(\'auth.footer_privacy\') }}",
    "Conditions" => "{{ __(\'auth.footer_terms\') }}",
    "Assistance" => "{{ __(\'auth.footer_support\') }}",
];

// Appliquer les traductions
foreach ($translations as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

// Sauvegarder le fichier
file_put_contents($registerFile, $content);

echo "✅ Traduction de register.blade.php complétée avec succès!\n";
echo "📝 Fichier mis à jour: $registerFile\n";
echo "\n";
echo "🎯 Prochaines étapes:\n";
echo "1. Vérifier le fichier register.blade.php\n";
echo "2. Tester le changement de langue sur les pages login et register\n";
echo "3. Vérifier que tous les formulaires fonctionnent correctement\n";
