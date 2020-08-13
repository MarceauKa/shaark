FROM php:7-alpine
MAINTAINER Shaark contributors <https://github.com/MarceauKa/shaark>

WORKDIR /app
COPY . /app

RUN apk add --update --no-cache gmp gmp-dev \
    && docker-php-ext-install gmp bcmath

RUN apk add --no-cache --update bash openssl zip unzip oniguruma-dev zlib-dev libpng-dev libzip-dev postgresql-dev && \
        cp .env.example .env && \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
        docker-php-ext-install pdo mbstring gd exif zip sockets pdo_mysql pgsql pdo_pgsql && \
        \
        composer install --no-dev -o && \
        php artisan optimize && \
        php artisan view:clear && \
        \
        php artisan key:generate && \
        php artisan storage:link && \
        php artisan config:cache

ENV \
  DB_HOST="mariadb" \
  REDIS_HOST="redis" \
  APP_ENV="production" \
  APP_DEBUG="false" \
  APP_URL="http://localhost" \
  APP_MIGRATE_DB="true" \
  CACHE_DRIVER="redis" \
  QUEUE_CONNECTION="redis" \
  SESSION_DRIVER="redis" \
  REDIS_HOST="redis"

ENTRYPOINT ["./app/run.sh"]
EXPOSE 80
