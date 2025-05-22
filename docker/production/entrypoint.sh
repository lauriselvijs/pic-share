#!/bin/sh

echo "Setting file permissions..."
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

mkdir -p /var/www/html/storage/logs
touch /var/www/html/storage/logs/horizon.log /var/www/html/storage/logs/horizon-error.log
chown www-data:www-data /var/www/html/storage/logs/horizon.log /var/www/html/storage/logs/horizon-error.log
chmod 664 /var/www/html/storage/logs/horizon.log /var/www/html/storage/logs/horizon-error.log

# Ensure compiled views directory exists
mkdir -p /var/www/html/storage/framework/views
chown -R www-data:www-data /var/www/html/storage/framework/views
chmod -R 775 /var/www/html/storage/framework/views

echo "Running Laravel optimizations..."
php artisan config:cache
php artisan route:cache
php artisan event:cache
php artisan view:cache

echo "Creating symbolic link for storage..."
php artisan storage:link

echo "Running database migrations..."
php artisan migrate --force

# Start
echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
