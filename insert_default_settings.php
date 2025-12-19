<?php
/**
 * Script pour insérer des settings par défaut dans la base de données
 * 
 * Ce script crée un enregistrement de settings global par défaut
 * pour permettre aux virements de fonctionner correctement.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

echo "=== INSERTION DES SETTINGS PAR DÉFAUT ===\n\n";

try {
    // Vérifier si des settings existent déjà
    $existingSettings = Setting::count();
    
    if ($existingSettings > 0) {
        echo "✓ Des settings existent déjà dans la base de données ($existingSettings enregistrement(s)).\n";
        echo "  Voulez-vous quand même créer un nouveau setting global par défaut? (y/n): ";
        
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        
        if (trim($line) !== 'y' && trim($line) !== 'Y') {
            echo "\n✗ Opération annulée.\n";
            exit(0);
        }
    }
    
    // Créer un setting global par défaut
    $setting = Setting::create([
        'stop_percentage' => 0,
        'stop_message' => 'Transaction en cours de traitement.',
        'is_global' => true,
        'target_user_id' => null
    ]);
    
    echo "\n✓ Setting global par défaut créé avec succès!\n";
    echo "\nDétails du setting créé:\n";
    echo "  - ID: {$setting->id}\n";
    echo "  - Stop Percentage: {$setting->stop_percentage}%\n";
    echo "  - Stop Message: {$setting->stop_message}\n";
    echo "  - Is Global: " . ($setting->is_global ? 'Oui' : 'Non') . "\n";
    echo "  - Target User ID: " . ($setting->target_user_id ?? 'Aucun (global)') . "\n";
    
    echo "\n✓ Les virements devraient maintenant fonctionner correctement!\n";
    echo "\nPour tester:\n";
    echo "1. Accédez à la page de création de virement\n";
    echo "2. Remplissez le formulaire\n";
    echo "3. Cliquez sur 'Lancer le virement'\n";
    echo "4. La barre de progression devrait s'afficher et progresser jusqu'à 100%\n";
    
    echo "\nPour configurer un stop_percentage:\n";
    echo "1. Connectez-vous en tant qu'admin\n";
    echo "2. Allez dans Paramètres (Settings)\n";
    echo "3. Modifiez le stop_percentage (ex: 50 pour arrêter à 50%)\n";
    echo "4. Sauvegardez\n";
    
} catch (\Exception $e) {
    echo "\n✗ Erreur lors de la création du setting:\n";
    echo "  " . $e->getMessage() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}

echo "\n=== FIN ===\n";
