#!/bin/bash
/usr/local/bin/php /app/artisan cache:clear
/usr/local/bin/php /app/artisan optimize
/usr/local/bin/php /app/artisan event:cache
/usr/local/bin/php /app/artisan view:cache
/usr/local/bin/php /app/artisan migrate --force
/usr/local/bin/php /app/artisan storage:link