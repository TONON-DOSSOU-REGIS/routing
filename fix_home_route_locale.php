<?php

/**
 * Script to fix all route('home') calls by adding the locale parameter
 * This fixes the UrlGenerationException: Missing required parameter for [Route: home] [URI: {locale}]
 */

$files = [
    'resources/views/home.blade.php',
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/dashboard/index.blade.php',
    'resources/views/profile/index.blade.php',
    'resources/views/about/notre-histoire.blade.php',
    'resources/views/about/carrieres.blade.php',
    'resources/views/about/presse.blade.php',
    'resources/views/about/blog.blade.php',
    'resources/views/services/comptes-professionnels.blade.php',
    'resources/views/services/gestion-tresorerie.blade.php',
    'resources/views/services/cartes-paiement.blade.php',
    'resources/views/services/virements-internationaux.blade.php',
    'resources/views/support/securite.blade.php',
    'resources/views/support/mentions-legales.blade.php',
    'resources/views/support/centre-aide.blade.php',
    'resources/views/support/nous-contacter.blade.php',
];

$filesUpdated = 0;
$totalReplacements = 0;

foreach ($files as $file) {
    if (!file_exists($file)) {
        echo "⚠️  File not found: $file\n";
        continue;
    }

    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Replace route('home') with route('home', ['locale' => app()->getLocale()])
    $pattern = "/route\s*\(\s*['\"]home['\"]\s*\)/";
    $replacement = "route('home', ['locale' => app()->getLocale()])";
    
    $content = preg_replace($pattern, $replacement, $content, -1, $count);
    
    if ($count > 0) {
        file_put_contents($file, $content);
        echo "✅ Updated $file ($count replacements)\n";
        $filesUpdated++;
        $totalReplacements += $count;
    } else {
        echo "ℹ️  No changes needed in $file\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 SUMMARY:\n";
echo "   Files updated: $filesUpdated\n";
echo "   Total replacements: $totalReplacements\n";
echo str_repeat("=", 60) . "\n";

if ($filesUpdated > 0) {
    echo "\n✅ All route('home') calls have been fixed!\n";
    echo "🔄 Next steps:\n";
    echo "   1. Clear route cache: php artisan route:clear\n";
    echo "   2. Clear view cache: php artisan view:clear\n";
    echo "   3. Test the application\n";
} else {
    echo "\nℹ️  No files needed updating.\n";
}
