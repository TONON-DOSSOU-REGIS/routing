<?php

// Test direct de l'API chat
$url = 'http://localhost/cerveau/chat/messages';

// Simuler une requête admin
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'X-Requested-With: XMLHttpRequest'
]);

echo "=== TEST API CHAT ===\n\n";
echo "URL: $url\n\n";

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response:\n";
echo $response;
echo "\n\n";

// Décoder la réponse
$data = json_decode($response, true);
if ($data) {
    echo "Decoded Response:\n";
    print_r($data);
} else {
    echo "Failed to decode JSON\n";
}

echo "\n=== FIN DU TEST ===\n";

