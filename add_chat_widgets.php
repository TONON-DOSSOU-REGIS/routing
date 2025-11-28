<?php

/**
 * Script pour ajouter les widgets de chat aux vues
 */

// Ajouter le widget utilisateur au profil
$profilePath = __DIR__ . '/resources/views/profile/index.blade.php';
if (file_exists($profilePath)) {
    $content = file_get_contents($profilePath);
    if (strpos($content, '@include(\'components.chat-widget\')') === false) {
        // Ajouter avant </body>
        $content = str_replace('</body>', '    @include(\'components.chat-widget\')' . PHP_EOL . '</body>', $content);
        file_put_contents($profilePath, $content);
        echo "✅ Widget chat ajouté à profile/index.blade.php\n";
    } else {
        echo "ℹ️  Widget chat déjà présent dans profile/index.blade.php\n";
    }
}

// Ajouter le widget admin aux pages admin
$adminPages = [
    'resources/views/admin/dashboard.blade.php',
    'resources/views/admin/users.blade.php',
    'resources/views/admin/settings.blade.php',
    'resources/views/admin/deposit.blade.php',
];

foreach ($adminPages as $pagePath) {
    $fullPath = __DIR__ . '/' . $pagePath;
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        if (strpos($content, '@include(\'components.admin-chat-widget\')') === false) {
            // Ajouter avant </body>
            $content = str_replace('</body>', '    @include(\'components.admin-chat-widget\')' . PHP_EOL . '</body>', $content);
            file_put_contents($fullPath, $content);
            echo "✅ Widget admin chat ajouté à $pagePath\n";
        } else {
            echo "ℹ️  Widget admin chat déjà présent dans $pagePath\n";
        }
    } else {
        echo "⚠️  Fichier non trouvé: $pagePath\n";
    }
}

echo "\n✅ Terminé!\n";

