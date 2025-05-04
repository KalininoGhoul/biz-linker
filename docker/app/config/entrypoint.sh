composer install --optimize-autoloader --no-interaction --no-progress

php artisan migrate --force
php artisan storage:link
php artisan optimize

supervisord -c /etc/supervisor/conf.d/supervisord.conf