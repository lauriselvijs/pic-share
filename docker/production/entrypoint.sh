#!/bin/sh

# Set correct permissions
echo "Setting file permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Laravel setup
echo "Running Laravel optimizations..."
php artisan optimize

# Migrate
echo "Running database migrations..."
php artisan migrate --force

# Start supervisord
echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf