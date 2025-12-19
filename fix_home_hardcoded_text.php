<?php

/**
 * Remplacer les textes en dur dans home.blade.php par des appels de traduction
 */

$filePath = __DIR__ . '/resources/views/home.blade.php';

if (!file_exists($filePath)) {
    die("❌ Fichier non trouvé: {$filePath}\n");
}

$content = file_get_contents($filePath);

// Remplacement 1: "SG BANK accompagne aussi bien..."
$search1 = "SG BANK accompagne aussi bien les particuliers que les professionnels avec une solution bancaire\n          moderne, accessible, rapide et extrêmement fiable.";
$replace1 = "{{ __('home.accompagne_description') }}";

$content = str_replace($search1, $replace1, $content);

// Remplacement 2: "SG BANK collabore avec des institutions..."
$search2 = "SG BANK collabore avec des institutions financières reconnues mondialement, afin de garantir\n          fiabilité, sécurité et qualité de service.";
$replace2 = "{{ __('home.collabore_description') }}";

$content = str_replace($search2, $replace2, $content);

// Sauvegarder
file_put_contents($filePath, $content);

echo "✅ home.blade.php mis à jour avec succès!\n";
echo "\nTextes remplacés:\n";
echo "1. 'SG BANK accompagne aussi bien...' → {{ __('home.accompagne_description') }}\n";
echo "2. 'SG BANK collabore avec des institutions...' → {{ __('home.collabore_description') }}\n";
