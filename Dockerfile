FROM php:7-alpine
MAINTAINER Pandry <togniand@gmail.com>

WORKDIR /app
COPY . /app

RUN apk add --no-cache --update openssl zip unzip oniguruma-dev zlib-dev libpng-dev libzip-dev postgresql-dev && \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
        docker-php-ext-install pdo mbstring gd exif zip sockets  pdo_mysql   pgsql pdo_pgsql && \
        cp .env.example .env && \
        \
        sed -i s/DB_HOST=127.0.0.1/DB_HOST=mariadb/ .env && \
        sed -i s/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/ .env && \
        sed -i s/APP_ENV=local/APP_ENV=production/ .env && \
        sed -i s/APP_DEBUG=true/APP_DEBUG=false/ .env && \
        sed -i s/CACHE_DRIVER=file/CACHE_DRIVER=redis/ .env && \
        sed -i s/QUEUE_CONNECTION=sync/QUEUE_CONNECTION=redis/ .env && \
        sed -i s/SESSION_DRIVER=file/SESSION_DRIVER=redis/ .env && \
        sed -i s/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/ .env && \
        \
        composer install --no-dev -o && \
        php artisan optimize && \
        php artisan view:clear && \
        \
        php artisan key:generate && \
        php artisan storage:link && \
        php artisan config:cache && \
        php artisan migrate --seed 

CMD php artisan serve --host=0.0.0.0 --port=80
EXPOSE 80
