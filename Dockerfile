FROM php:alpine
MAINTAINER Shaark contributors <https://github.com/MarceauKa/shaark>

WORKDIR /app
COPY . /app

RUN apk add --no-cache bash openssl zip unzip oniguruma-dev zlib-dev libpng-dev libzip-dev postgresql-dev gmp gmp-dev nodejs npm python3 git libcap

# 
RUN setcap cap_net_raw+eip /app/app/entrypoint-shaark.sh && \
    setcap cap_sys_admin+eip /app/app/entrypoint-shaark.sh

# Installs latest Chromium (77) package.
RUN apk add --no-cache \
      chromium \
      nss \
      freetype \
      freetype-dev \
      harfbuzz \
      ca-certificates \
      ttf-freefont \
      nodejs \
      npm

# Tell Puppeteer to skip installing Chrome. We'll be using the installed package.
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true \
    PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser \
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

# Puppeteer v1.19.0 works with Chromium 77.
RUN npm install puppeteer@1.19.0 && \
    npm install @nesk/puphpeteer --no-save

# Add user so we don't need --no-sandbox.
RUN addgroup -S pptruser && adduser -S -g pptruser pptruser \
    && mkdir -p /home/pptruser/Downloads /app \
    && chown -R pptruser:pptruser /home/pptruser \
    && chown -R pptruser:pptruser /app

# Install youtube-dl binary
RUN curl -L https://yt-dl.org/downloads/latest/youtube-dl -o /usr/bin/youtube-dl && \
    chmod a+rx /usr/bin/youtube-dl

# Make sure python binary is python3
RUN if [ ! -e /usr/bin/python ]; then ln -sf /usr/bin/python3 /usr/bin/python; fi

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    docker-php-ext-install pdo mbstring gd exif zip sockets pdo_mysql pgsql pdo_pgsql gmp bcmath

# Run everything after as non-privileged user.
USER pptruser

RUN composer install --no-dev -o 


RUN cp .env.example .env && \
    \
    php artisan optimize && \
    php artisan view:clear && \
    \
    php artisan key:generate && \
    php artisan storage:link


ENTRYPOINT [ "./app/entrypoint-shaark.sh" ]
EXPOSE 80
