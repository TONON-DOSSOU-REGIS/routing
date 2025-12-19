<?php

/**
 * Comprehensive script to fix ALL route calls within locale prefix by adding the locale parameter
 * This fixes UrlGenerationException errors for all routes requiring locale
 */

// Get all view files
$viewFiles = [];
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator('resources/views', RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $viewFiles[] = $file->getPathname();
    }
}

$filesUpdated = 0;
$totalReplacements = 0;

// Routes that need locale parameter (all routes within the locale prefix group)
$routePatterns = [
    'home',
    'login',
    'register',
    'logout',
    'password\.request',
    'password\.email',
    'password\.reset',
    'password\.update',
    'services\.comptes-professionnels',
    'services\.virements-internationaux',
    'services\.gestion-tresorerie',
    'services\.cartes-paiement',
    'about\.notre-histoire',
    'about\.carrieres',
    'about\.presse',
    'about\.blog',
    'support\.securite',
    'support\.mentions-legales',
    'support\.centre-aide',
    'support\.nous-contacter',
    'support\.nous-contacter\.thankyou',
    'dashboard',
    'profile',
    'transfer\.create',
    'transactions\.create',
    'transactions\.start',
    'transactions\.progress',
    'transactions\.history',
    'notifications\.index',
    'notifications\.data',
    'notifications\.recent',
    'notifications\.unreadCount',
    'notifications\.show',
    'notifications\.markAsRead',
    'notifications\.markAllAsRead',
    'notifications\.deleteAllRead',
];

foreach ($viewFiles as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    $fileReplacements = 0;
    
    foreach ($routePatterns as $routePattern) {
        // Match route('route.name') but NOT route('route.name', [...])
        $pattern = "/route\s*\(\s*['\"]" . $routePattern . "['\"]\s*\)(?!\s*,\s*\[)/";
        $replacement = "route('" . str_replace('\\', '', $routePattern) . "', ['locale' => app()->getLocale()])";
        
        $content = preg_replace($pattern, $replacement, $content, -1, $count);
        $fileReplacements += $count;
    }
    
    if ($fileReplacements > 0) {
        file_put_contents($file, $content);
        $relativePath = str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $file);
        echo "✅ Updated $relativePath ($fileReplacements replacements)\n";
        $filesUpdated++;
        $totalReplacements += $fileReplacements;
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 SUMMARY:\n";
echo "   Files scanned: " . count($viewFiles) . "\n";
echo "   Files updated: $filesUpdated\n";
echo "   Total replacements: $totalReplacements\n";
echo str_repeat("=", 60) . "\n";

if ($filesUpdated > 0) {
    echo "\n✅ All route calls have been fixed with locale parameters!\n";
    echo "🔄 Next steps:\n";
    echo "   1. Clear route cache: php artisan route:clear\n";
    echo "   2. Clear view cache: php artisan view:clear\n";
    echo "   3. Test the application\n";
} else {
    echo "\nℹ️  No files needed updating.\n";
}
