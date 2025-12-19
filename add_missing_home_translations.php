<?php

/**
 * Ajouter les traductions manquantes pour home.blade.php
 */

$translations = [
    'fr' => [
        'accompagne_description' => 'SG BANK accompagne aussi bien les particuliers que les professionnels avec une solution bancaire moderne, accessible, rapide et extrêmement fiable.',
        'collabore_description' => 'SG BANK collabore avec des institutions financières reconnues mondialement, afin de garantir fiabilité, sécurité et qualité de service.',
    ],
    'en' => [
        'accompagne_description' => 'SG BANK supports both individuals and professionals with a modern, accessible, fast and extremely reliable banking solution.',
        'collabore_description' => 'SG BANK collaborates with globally recognized financial institutions to guarantee reliability, security and quality of service.',
    ],
    'de' => [
        'accompagne_description' => 'SG BANK unterstützt sowohl Privatpersonen als auch Unternehmen mit einer modernen, zugänglichen, schnellen und äußerst zuverlässigen Banklösung.',
        'collabore_description' => 'SG BANK arbeitet mit weltweit anerkannten Finanzinstituten zusammen, um Zuverlässigkeit, Sicherheit und Servicequalität zu gewährleisten.',
    ],
    'nl' => [
        'accompagne_description' => 'SG BANK ondersteunt zowel particulieren als professionals met een moderne, toegankelijke, snelle en uiterst betrouwbare bankoplossing.',
        'collabore_description' => 'SG BANK werkt samen met wereldwijd erkende financiële instellingen om betrouwbaarheid, veiligheid en servicekwaliteit te garanderen.',
    ],
    'es' => [
        'accompagne_description' => 'SG BANK acompaña tanto a particulares como a profesionales con una solución bancaria moderna, accesible, rápida y extremadamente fiable.',
        'collabore_description' => 'SG BANK colabora con instituciones financieras reconocidas mundialmente para garantizar fiabilidad, seguridad y calidad de servicio.',
    ],
    'pl' => [
        'accompagne_description' => 'SG BANK wspiera zarówno osoby prywatne, jak i profesjonalistów nowoczesnym, dostępnym, szybkim i niezwykle niezawodnym rozwiązaniem bankowym.',
        'collabore_description' => 'SG BANK współpracuje z uznanymi na całym świecie instytucjami finansowymi, aby zagwarantować niezawodność, bezpieczeństwo i jakość usług.',
    ],
    'it' => [
        'accompagne_description' => 'SG BANK accompagna sia privati che professionisti con una soluzione bancaria moderna, accessibile, veloce ed estremamente affidabile.',
        'collabore_description' => 'SG BANK collabora con istituzioni finanziarie riconosciute a livello mondiale per garantire affidabilità, sicurezza e qualità del servizio.',
    ],
];

echo "Ajout des traductions manquantes...\n\n";

foreach ($translations as $locale => $trans) {
    $filePath = __DIR__ . "/lang/{$locale}/home.php";
    
    if (!file_exists($filePath)) {
        echo "❌ Fichier non trouvé: {$filePath}\n";
        continue;
    }
    
    $content = file_get_contents($filePath);
    
    // Vérifier si les clés existent déjà
    if (strpos($content, "'accompagne_description'") !== false) {
        echo "ℹ️  {$locale}/home.php - accompagne_description existe déjà\n";
        continue;
    }
    
    // Trouver la position avant le dernier ];
    $lastBracketPos = strrpos($content, '];');
    
    if ($lastBracketPos === false) {
        echo "❌ Impossible de trouver ]; dans {$locale}/home.php\n";
        continue;
    }
    
    // Préparer les nouvelles lignes
    $newLines = "\n    'accompagne_description' => '{$trans['accompagne_description']}',\n";
    $newLines .= "    'collabore_description' => '{$trans['collabore_description']}',\n";
    
    // Insérer avant le dernier ];
    $newContent = substr($content, 0, $lastBracketPos) . $newLines . substr($content, $lastBracketPos);
    
    // Sauvegarder
    file_put_contents($filePath, $newContent);
    
    echo "✅ {$locale}/home.php - Traductions ajoutées\n";
}

echo "\n" . str_repeat('=', 80) . "\n";
echo "Traductions ajoutées avec succès!\n";
echo str_repeat('=', 80) . "\n\n";
echo "Prochaine étape: Mettre à jour resources/views/home.blade.php\n";
