FROM alpine

RUN apk update && apk upgrade \
    && apk add --no-cache php8 php8-mbstring php8-xml php8-pdo php8-mysqli php8-bcmath php8-ctype php8-zip \
    php8-imap php8-curl php8-json php8-gettext php8-gd php8-session php8-snmp php8-pdo_mysql php8-tokenizer \
    php8-openssl php8-sockets php8-fileinfo php8-dom php8-exif php8-simplexml php8-xmlwriter php8-xmlreader\
    php8-sqlite3 php8-pdo_sqlite php8-pcntl composer nodejs php8-apache2 apache2 npm git python3 ca-certificates \
    curl ffmpeg chromium ttf-freefont font-noto-emoji  \
    && curl -Lo /usr/bin/yt-dlp https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp \
    && chmod a+rx /usr/bin/yt-dlp \
    && apk del curl

EXPOSE 80

RUN mkdir -p /var/www/laravel && \
    sed -i 's#^DocumentRoot ".*#DocumentRoot "/var/www/laravel/public"#g' /etc/apache2/httpd.conf && \
    sed -i 's#AllowOverride [Nn]one#AllowOverride All#' /etc/apache2/httpd.conf && \
    sed -i 's#Directory "/var/www/localhost/htdocs.*#Directory "/var/www/laravel/public" >#g' /etc/apache2/httpd.conf && \
    sed -i 's#\#LoadModule rewrite_module modules/mod_rewrite.so#LoadModule rewrite_module modules/mod_rewrite.so#' /etc/apache2/httpd.conf

WORKDIR /var/www/laravel

COPY . .

RUN echo "* * * * * cd /var/www/laravel && php artisan schedule:run >> /dev/null 2>&1" > /crontab.txt && \
    /usr/bin/crontab /crontab.txt && \
    echo -e "#!/bin/sh\n/usr/sbin/crond -b -l 8\n/usr/sbin/httpd -D FOREGROUND" > /entrypoint.sh && chmod +x /entrypoint.sh

RUN find . -type f -exec chmod 664 {} \; \
    && find . -type d -exec chmod 775 {} \; \
    && chown -R apache:apache * . \
    && composer install --no-dev -o \
    && npm install  \
    && chmod -R a+x node_modules  \
    && npm run production  \
    && php8 artisan optimize \
    && php8 artisan view:clear \
    && adduser -D chrome

ENTRYPOINT ["/entrypoint.sh"]
