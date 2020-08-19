#!/bin/bash
FILE=.app_initialized

cd /app
echo "Clearing any cached config."
php artisan config:clear
if [ ! -f $FILE ]; then
  echo "Migrating database and creating default Admin user."
  php artisan migrate --seed --force
  echo "Admin Username: admin@example.com"
  echo "Admin Password: secret"
  touch $FILE
elif [ "${APP_MIGRATE_DB}" = 'true' ]; then
    echo "Migrating database."
    php artisan migrate --force
else
  echo "Database migration skipped."
fi
php artisan serve --host=0.0.0.0 --port=8080
