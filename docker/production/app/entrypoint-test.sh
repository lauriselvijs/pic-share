#!/bin/sh

echo "Setting file permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "Running Laravel optimizations..."
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "Creating symbolic link for storage..."
php artisan storage:link

echo "Installing chrome driver..."
php artisan dusk:chrome-driver

# Start
echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf