#!/usr/bin/env bash
echo "Running composer"
composer install --optimize-autoloader --no-dev --working-dir=/var/www/html

echo "Running npm"
npm ci
npm run build

echo "Optimizing..."
php artisan cache:clear
php artisan optimize
php artisan event:cache
php artisan view:cache

echo "Migrating and seeding DB..."
php artisan migrate:refresh --force --seed

echo "Creating storge link..."
php artisan storage:link