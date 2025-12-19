<?php

/**
 * Script de diagnostic et correction pour les problèmes de traduction et de cache
 * 
 * Ce script va:
 * 1. Vérifier l'état actuel du système
 * 2. Nettoyer tous les caches
 * 3. Régénérer les fichiers nécessaires
 * 4. Tester le système de traduction
 */

echo "=== DIAGNOSTIC ET CORRECTION DU SYSTÈME DE TRADUCTION ===\n\n";

// Fonction pour exécuter une commande et afficher le résultat
function runCommand($command, $description) {
    echo "➤ $description\n";
    echo "  Commande: $command\n";
    
    $output = [];
    $returnVar = 0;
    exec($command . " 2>&1", $output, $returnVar);
    
    foreach ($output as $line) {
        echo "  " . $line . "\n";
    }
    
    if ($returnVar === 0) {
        echo "  ✓ Succès\n\n";
    } else {
        echo "  ✗ Erreur (code: $returnVar)\n\n";
    }
    
    return $returnVar === 0;
}

// 1. Vérifier l'environnement
echo "ÉTAPE 1: Vérification de l'environnement\n";
echo str_repeat("-", 50) . "\n";

if (file_exists('.env')) {
    echo "✓ Fichier .env trouvé\n";
} else {
    echo "✗ Fichier .env manquant\n";
}

if (file_exists('bootstrap/cache/config.php')) {
    echo "⚠ Cache de configuration détecté\n";
} else {
    echo "✓ Pas de cache de configuration\n";
}

if (file_exists('bootstrap/cache/routes-v7.php')) {
    echo "⚠ Cache de routes détecté\n";
} else {
    echo "✓ Pas de cache de routes\n";
}

echo "\n";

// 2. Nettoyer tous les caches
echo "ÉTAPE 2: Nettoyage des caches\n";
echo str_repeat("-", 50) . "\n";

runCommand("php artisan config:clear", "Nettoyage du cache de configuration");
runCommand("php artisan route:clear", "Nettoyage du cache de routes");
runCommand("php artisan view:clear", "Nettoyage du cache de vues");
runCommand("php artisan cache:clear", "Nettoyage du cache d'application");
runCommand("php artisan clear-compiled", "Nettoyage des fichiers compilés");

// 3. Régénérer l'autoload de Composer
echo "ÉTAPE 3: Régénération de l'autoload Composer\n";
echo str_repeat("-", 50) . "\n";

runCommand("composer dump-autoload", "Régénération de l'autoload");

// 4. Vérifier les fichiers de traduction
echo "ÉTAPE 4: Vérification des fichiers de traduction\n";
echo str_repeat("-", 50) . "\n";

$languages = ['en', 'fr', 'de', 'nl', 'es', 'pl', 'it'];
$translationFiles = ['home.php', 'common.php', 'auth.php'];

foreach ($languages as $lang) {
    echo "Langue: $lang\n";
    foreach ($translationFiles as $file) {
        $path = "lang/$lang/$file";
        if (file_exists($path)) {
            echo "  ✓ $file existe\n";
        } else {
            echo "  ✗ $file manquant\n";
        }
    }
    echo "\n";
}

// 5. Tester le système de traduction
echo "ÉTAPE 5: Test du système de traduction\n";
echo str_repeat("-", 50) . "\n";

// Créer un script de test PHP
$testScript = <<<'PHP'
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Test de traduction:\n";
foreach (['en', 'fr', 'de', 'nl'] as $locale) {
    app()->setLocale($locale);
    echo "  $locale: " . __('common.welcome') . "\n";
}
PHP;

file_put_contents('test_translation_system.php', $testScript);
runCommand("php test_translation_system.php", "Test des traductions");
@unlink('test_translation_system.php');

// 6. Vérifier les sessions
echo "ÉTAPE 6: Vérification de la configuration des sessions\n";
echo str_repeat("-", 50) . "\n";

if (file_exists('database/migrations/2025_12_14_231311_create_sessions_table.php')) {
    echo "✓ Migration de sessions trouvée\n";
    runCommand("php artisan migrate --force", "Exécution des migrations");
} else {
    echo "⚠ Migration de sessions non trouvée\n";
}

echo "\n";

// 7. Recommandations finales
echo "ÉTAPE 7: Recommandations\n";
echo str_repeat("-", 50) . "\n";
echo "1. Redémarrez votre serveur web (Apache/Nginx)\n";
echo "2. Videz le cache de votre navigateur\n";
echo "3. Testez le sélecteur de langue sur: http://localhost/cerveau\n";
echo "4. Vérifiez que la session est bien configurée dans .env:\n";
echo "   SESSION_DRIVER=database\n";
echo "   SESSION_LIFETIME=120\n\n";

echo "=== DIAGNOSTIC TERMINÉ ===\n";
