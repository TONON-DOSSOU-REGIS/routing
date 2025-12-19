<?php

/**
 * Script to find and fix all route() calls in Blade views
 * that are missing the locale parameter
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

function findRouteCallsWithoutLocale($content) {
    $matches = [];
    
    // Pattern to match route() calls that don't have locale parameter
    // This is a simplified pattern - may need refinement
    $pattern = '/route\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/';
    
    preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);
    
    return $matches;
}

echo "Scanning Blade views for route() calls without locale parameter...\n\n";

$files = [];
scanDirectory($viewsPath, $files);

echo "Found " . count($files) . " Blade view files.\n\n";

$issuesFound = [];

foreach ($files as $file) {
    $content = file_get_contents($file);
    $matches = findRouteCallsWithoutLocale($content);
    
    if (!empty($matches[0])) {
        $relativePath = str_replace(__DIR__ . '/', '', $file);
        
        foreach ($matches[0] as $index => $match) {
            $routeName = $matches[1][$index][0];
            $fullMatch = $match[0];
            
            // Skip if it already has parameters (basic check)
            if (strpos($fullMatch, ',') !== false) {
                continue;
            }
            
            // Skip if it's using localized_route
            if (strpos($fullMatch, 'localized_route') !== false) {
                continue;
            }
            
            $issuesFound[] = [
                'file' => $relativePath,
                'route' => $routeName,
                'match' => $fullMatch,
                'line' => substr_count(substr($content, 0, $match[1]), "\n") + 1
            ];
        }
    }
}

if (empty($issuesFound)) {
    echo "✅ No issues found! All route() calls appear to have parameters or are using localized_route().\n";
} else {
    echo "⚠️  Found " . count($issuesFound) . " potential issues:\n\n";
    
    foreach ($issuesFound as $issue) {
        echo "File: {$issue['file']}\n";
        echo "Line: {$issue['line']}\n";
        echo "Route: {$issue['route']}\n";
        echo "Current: {$issue['match']}\n";
        echo "Suggested fix: route('{$issue['route']}', ['locale' => app()->getLocale()])\n";
        echo "Or use: localized_route('{$issue['route']}')\n";
        echo str_repeat('-', 80) . "\n\n";
    }
    
    echo "\n📝 RECOMMENDATION:\n";
    echo "Instead of manually fixing each route() call, consider using the new localized_route() helper:\n";
    echo "  Before: route('dashboard')\n";
    echo "  After:  localized_route('dashboard')\n\n";
    echo "The helper automatically adds the locale parameter for you!\n";
}

echo "\nDone!\n";
