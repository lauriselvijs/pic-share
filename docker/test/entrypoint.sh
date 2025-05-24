#!/bin/sh

mkdir -p /var/log/supervisord

find ./ -type f -exec chmod 644 {} \;
find ./ -type d -exec chmod 755 {} \;

mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/views

chown -R root:www-data /var/www/html
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 774 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Running Laravel optimizations..."
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache
php /var/www/html/artisan event:cache

echo "Creating symbolic link for storage..."
php /var/www/html/artisan storage:link

echo "Running database migrations..."
php /var/www/html/artisan migrate --force

# Start
echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
