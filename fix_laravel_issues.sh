#!/bin/bash
# Script to fix Laravel issues related to migrations, caching, and autoloading

echo "Running database migrations..."
php artisan migrate

echo "Clearing Laravel caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Dumping composer autoload files..."
composer dump-autoload

echo "Please restart your server and test the application."

