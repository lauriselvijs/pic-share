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
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache
php /var/www/html/artisan event:cache

chmod 440 /var/www/html/.env

echo "Creating symbolic link for storage..."
php /var/www/html/artisan storage:link

echo "Wiping the database..."
php /var/www/html/artisan db:wipe --force

echo "Running database migrations..."
php /var/www/html/artisan migrate --force

echo "Running database seeder..."
php /var/www/html/artisan db:seed --force

echo "Flushing Scout models..."
php /var/www/html/artisan scout:flush "App\Models\Post"

echo "Importing Scout models..."
php /var/www/html/artisan scout:import "App\Models\Post"

# Start
echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
