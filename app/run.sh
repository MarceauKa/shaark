#!/bin/bash

cd /app

if [ "${APP_MIGRATE_DB} = 'true'" ]; then
  if [ "${APP_ENV} = dev" ]; then
    echo "Migrating database and creating default user admin@example.com:secret." && \
    php artisan migrate --seed --force
  else
    echo "Migrating database with no data; user must be created manually." && \
    php artisan migrate --force
  fi
else
  echo "Database migration skipped."
  echo "If this is the first time running this compose file, you should run \`SHAARK_MIGRATE_DB=true eval 'docker-compose up'\` first to perform initial database migration."
fi
php artisan serve --host=0.0.0.0 --port=80
