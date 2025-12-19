<?php

/**
 * Fix route() calls that have parameters (like $user, $transaction, etc.)
 */

$viewsPath = __DIR__ . '/resources/views';

function scanDirectory($dir, &$files = []) {
    if (!is_dir($dir)) {
        return $files;
    }
    
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            scanDirectory($path, $files);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $files[] = $path;
        }
    }
    
    return $files;
}

echo "Fixing route() calls with parameters...\n\n";

$files = [];
scanDirectory($viewsPath, $files);

$totalReplacements = 0;
$filesModified = 0;

foreach ($files as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Replace route('name', $param) with localized_route('name', $param)
    // This pattern matches route calls with parameters
    $pattern = '/\broute\s*\(\s*([\'"][^\'"]+[\'"])\s*,\s*([^)]+)\)/';
    $replacement = 'localized_route($1, $2)';
    
    $content = preg_replace($pattern, $replacement, $content, -1, $count);
    
    if ($count > 0) {
        file_put_contents($file, $content);
        $totalReplacements += $count;
        $filesModified++;
        
        $relativePath = str_replace(__DIR__ . '/', '', $file);
        echo "✓ Modified: $relativePath ($count replacements)\n";
    }
}

echo "\n" . str_repeat('=', 80) . "\n";
echo "SUMMARY:\n";
echo "Files modified: $filesModified\n";
echo "Total replacements: $totalReplacements\n";
echo str_repeat('=', 80) . "\n\n";

if ($totalReplacements > 0) {
    echo "✅ SUCCESS! All route() calls with parameters have been replaced.\n";
    echo "\nNext step: php artisan view:clear\n";
} else {
    echo "ℹ️  No replacements needed.\n";
}

echo "\nDone!\n";
