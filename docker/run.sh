#!/bin/sh

cd /var/www

# php artisan migrate:fresh --seed
# php artisan cache:clear
# php artisan route:cache
php artisan optimize
php artisan route:clear
php artisan route:cache
php artisan config:clear
php artisan config:cache
php artisan view:clear
php artisan view:cache
php artisan storage:link

/usr/bin/supervisord -c /etc/supervisord.conf
