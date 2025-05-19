#!/bin/sh

echo "Setting file permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "Setting horizon log file permissions..."
mkdir -p /var/www/storage/logs
touch /var/www/storage/logs/horizon.log /var/www/storage/logs/horizon-error.log
chown www-data:www-data /var/www/storage/logs/horizon.log /var/www/storage/logs/horizon-error.log
chmod 664 /var/www/storage/logs/horizon.log /var/www/storage/logs/horizon-error.log

echo "Running Laravel optimizations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "Running database migrations..."/
php artisan migrate --force

echo "Creating symbolic link for storage..."
php artisan storage:link

# Start
echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf