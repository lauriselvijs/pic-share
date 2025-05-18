#!/bin/sh

echo "Setting file permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "Running Laravel optimizations..."
php artisan optimize

echo "Running database migrations..."
php artisan migrate --force

php artisan storage:link

# Start 
echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf