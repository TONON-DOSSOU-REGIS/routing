<?php
/**
 * Script de test pour vérifier la correction de l'erreur Analytics
 * 
 * Ce script teste:
 * 1. Les endpoints API retournent du JSON valide
 * 2. L'authentification fonctionne correctement
 * 3. Les données sont correctement formatées
 */

echo "=== Test de correction Analytics Dashboard ===\n\n";

// Configuration
$baseUrl = 'http://localhost:8000'; // Ajustez selon votre configuration
$apiEndpoints = [
    '/api/analytics/balance-evolution?days=30',
    '/api/analytics/transactions-by-type?days=30',
    '/api/analytics/monthly-comparison',
    '/api/analytics/statistics?days=30'
];

echo "URL de base: $baseUrl\n\n";

// Fonction pour tester un endpoint
function testEndpoint($url) {
    echo "Test de: $url\n";
    echo str_repeat('-', 60) . "\n";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    
    curl_close($ch);
    
    echo "Code HTTP: $httpCode\n";
    
    // Vérifier le Content-Type
    if (preg_match('/Content-Type:\s*([^\r\n]+)/i', $headers, $matches)) {
        $contentType = trim($matches[1]);
        echo "Content-Type: $contentType\n";
        
        if (strpos($contentType, 'application/json') !== false) {
            echo "✓ Content-Type correct (JSON)\n";
        } else {
            echo "✗ Content-Type incorrect (attendu: application/json)\n";
        }
    }
    
    // Vérifier si c'est du JSON valide
    $jsonData = json_decode($body, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "✓ Réponse JSON valide\n";
        echo "Structure de la réponse:\n";
        print_r(array_keys($jsonData));
    } else {
        echo "✗ Réponse JSON invalide\n";
        echo "Erreur JSON: " . json_last_error_msg() . "\n";
        echo "Début de la réponse:\n";
        echo substr($body, 0, 200) . "...\n";
    }
    
    echo "\n";
    
    return [
        'http_code' => $httpCode,
        'is_json' => json_last_error() === JSON_ERROR_NONE,
        'content_type' => $contentType ?? 'unknown'
    ];
}

// Tester chaque endpoint
$results = [];
foreach ($apiEndpoints as $endpoint) {
    $fullUrl = $baseUrl . $endpoint;
    $results[$endpoint] = testEndpoint($fullUrl);
}

// Résumé
echo "\n" . str_repeat('=', 60) . "\n";
echo "RÉSUMÉ DES TESTS\n";
echo str_repeat('=', 60) . "\n\n";

$allPassed = true;
foreach ($results as $endpoint => $result) {
    $status = ($result['http_code'] === 200 && $result['is_json']) ? '✓ PASS' : '✗ FAIL';
    echo "$status - $endpoint\n";
    
    if ($result['http_code'] !== 200 || !$result['is_json']) {
        $allPassed = false;
        echo "  → Code HTTP: {$result['http_code']}\n";
        echo "  → JSON valide: " . ($result['is_json'] ? 'Oui' : 'Non') . "\n";
        echo "  → Content-Type: {$result['content_type']}\n";
    }
}

echo "\n";
if ($allPassed) {
    echo "✓ Tous les tests sont passés!\n";
    echo "Les endpoints API retournent correctement du JSON.\n";
} else {
    echo "✗ Certains tests ont échoué.\n";
    echo "\nRECOMMANDATIONS:\n";
    echo "1. Assurez-vous que le serveur Laravel est démarré\n";
    echo "2. Vérifiez que vous êtes connecté (les routes nécessitent l'authentification)\n";
    echo "3. Vérifiez les logs Laravel pour plus de détails: storage/logs/laravel.log\n";
}

echo "\n" . str_repeat('=', 60) . "\n";
