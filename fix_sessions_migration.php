<?php

/**
 * Script to clean up the duplicate sessions migration entry from the database
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Checking for duplicate sessions migration entry...\n\n";
    
    // Check if the duplicate migration exists in the migrations table
    $migration = DB::table('migrations')
        ->where('migration', '2025_12_14_231311_create_sessions_table')
        ->first();
    
    if ($migration) {
        echo "Found duplicate migration entry: 2025_12_14_231311_create_sessions_table\n";
        echo "Batch: {$migration->batch}\n\n";
        
        // Delete the duplicate migration entry
        $deleted = DB::table('migrations')
            ->where('migration', '2025_12_14_231311_create_sessions_table')
            ->delete();
        
        if ($deleted) {
            echo "✓ Successfully removed duplicate migration entry from database\n\n";
        } else {
            echo "✗ Failed to remove migration entry\n\n";
        }
    } else {
        echo "✓ No duplicate migration entry found in database\n\n";
    }
    
    // Show all sessions-related migrations
    echo "Current sessions-related migrations in database:\n";
    echo "------------------------------------------------\n";
    
    $sessionsMigrations = DB::table('migrations')
        ->where('migration', 'like', '%session%')
        ->orderBy('id')
        ->get();
    
    if ($sessionsMigrations->isEmpty()) {
        echo "No sessions-related migrations found.\n";
    } else {
        foreach ($sessionsMigrations as $mig) {
            echo "- {$mig->migration} (Batch: {$mig->batch})\n";
        }
    }
    
    echo "\n✓ Cleanup complete!\n";
    echo "\nYou can now run: php artisan migrate\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
