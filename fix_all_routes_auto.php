<?php

/**
 * Automated script to replace route() with localized_route() in all Blade views
 */

$viewsPath = __DIR__ . '/resources/views';
$excludePatterns = ['vendor', 'node_modules', 'storage'];

function scanDirectory($dir, &$files = []) {
    global $excludePatterns;
    
    if (!is_dir($dir)) {
        return $files;
    }
    
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        
        $path = $dir . '/' . $item;
        
        // Skip excluded directories
        $skip = false;
        foreach ($excludePatterns as $pattern) {
            if (strpos($path, $pattern) !== false) {
                $skip = true;
                break;
            }
        }
        
        if ($skip) {
            continue;
        }
        
        if (is_dir($path)) {
            scanDirectory($path, $files);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $files[] = $path;
        }
    }
    
    return $files;
}

echo "Starting automated route() to localized_route() replacement...\n\n";

$files = [];
scanDirectory($viewsPath, $files);

echo "Found " . count($files) . " Blade view files.\n\n";

$totalReplacements = 0;
$filesModified = 0;

foreach ($files as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Replace route(' with localized_route(' but only for simple calls without parameters
    // Pattern: route('route.name') -> localized_route('route.name')
    $pattern = '/\broute\s*\(\s*([\'"][^\'"]+[\'"])\s*\)/';
    $replacement = 'localized_route($1)';
    
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
    echo "✅ SUCCESS! All route() calls have been replaced with localized_route().\n";
    echo "\nNext steps:\n";
    echo "1. Clear view cache: php artisan view:clear\n";
    echo "2. Test your application\n";
    echo "3. If any issues, check the modified files\n";
} else {
    echo "ℹ️  No replacements needed. All route() calls already have parameters or use localized_route().\n";
}

echo "\nDone!\n";
