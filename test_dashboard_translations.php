<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$locales = ['en', 'fr', 'es', 'de', 'nl', 'it', 'pl'];

$translationKeys = [
    'dashboard.transaction_type',
    'dashboard.transaction_id_prefix',
    'dashboard.date_format',
    'dashboard.zero_amount',
    'dashboard.card_mask_prefix',
    'dashboard.empty_value'
];

echo "Testing Dashboard Translation Keys\n";
echo "===================================\n\n";

foreach ($locales as $locale) {
    App::setLocale($locale);
    echo "Locale: $locale\n";
    echo "------------\n";

    foreach ($translationKeys as $key) {
        $translation = __($key);
        echo "  $key: '$translation'\n";
    }

    echo "\n";
}

echo "Translation test completed!\n";
