<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test 1: Vérifier la langue par défaut
echo "Test 1: Langue par défaut\n";
echo "Locale actuelle: " . app()->getLocale() . "\n";
echo "Traduction 'home.nav_home': " . __('home.nav_home') . "\n\n";

// Test 2: Changer la langue en DE
echo "Test 2: Changement vers DE (Allemand)\n";
app()->setLocale('de');
echo "Locale actuelle: " . app()->getLocale() . "\n";
echo "Traduction 'home.nav_home': " . __('home.nav_home') . "\n\n";

// Test 3: Changer la langue en NL
echo "Test 3: Changement vers NL (Néerlandais)\n";
app()->setLocale('nl');
echo "Locale actuelle: " . app()->getLocale() . "\n";
echo "Traduction 'home.nav_home': " . __('home.nav_home') . "\n\n";

// Test 4: Changer la langue en ES
echo "Test 4: Changement vers ES (Espagnol)\n";
app()->setLocale('es');
echo "Locale actuelle: " . app()->getLocale() . "\n";
echo "Traduction 'home.nav_home': " . __('home.nav_home') . "\n\n";

// Test 5: Changer la langue en FR
echo "Test 5: Changement vers FR (Français)\n";
app()->setLocale('fr');
echo "Locale actuelle: " . app()->getLocale() . "\n";
echo "Traduction 'home.nav_home': " . __('home.nav_home') . "\n\n";

// Test 6: Changer la langue en EN
echo "Test 6: Changement vers EN (Anglais)\n";
app()->setLocale('en');
echo "Locale actuelle: " . app()->getLocale() . "\n";
echo "Traduction 'home.nav_home': " . __('home.nav_home') . "\n\n";

echo "Tests terminés!\n";
