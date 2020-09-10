#!/bin/bash

cd /app
echo "Clearing any cached config."
php artisan config:clear
if [ "`php artisan migrate:status`" = "Migration table not found." ]; then
    echo "Migrating database and creating default Admin user."
    php artisan migrate --seed --force
    echo "Admin Username: admin@example.com"
    echo "Admin Password: "${APP_ADMIN_PASSWORD}
elif [ "${APP_MIGRATE_DB}" = 'true' ] && \
    [ `php artisan migrate:status|cut -d'|' -f2 |grep -c "No"` -gt 0 ]; then
    echo "Migrating database."
    php artisan migrate --force
else
  echo "Database migration skipped."
fi

if [ "${APP_DEBUG}" = 'true' ]; then
    echo "Debugging enabled: creating verbose logs at /app/storage/logs/"
    php artisan queue:work >> storage/logs/artisan_queue.log &
    php artisan serve --host=0.0.0.0 --port=80 -vvv >> storage/logs/artisan_serve.log
else
    echo "Starting Shaark!"
    php artisan queue:work &
    php artisan serve --host=0.0.0.0 --port=80
fi
