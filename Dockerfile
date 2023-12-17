FROM alpine

RUN apk update && apk upgrade \
    && apk add --no-cache php82 php82-mbstring php82-xml php82-pdo php82-mysqli php82-bcmath php82-ctype php82-zip \
    php82-imap php82-curl php82-json php82-gettext php82-gd php82-session php82-snmp php82-pdo_mysql php82-tokenizer \
    php82-openssl php82-sockets php82-fileinfo php82-dom php82-exif php82-simplexml php82-xmlwriter php82-xmlreader\
    php82-sqlite3 php82-pdo_sqlite php82-pcntl php82-gd php82-iconv php82-phar composer nodejs php82-apache2 apache2 npm git python3 ca-certificates \
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
    && php artisan optimize \
    && php artisan view:clear \
    && adduser -D chrome

ENTRYPOINT ["/entrypoint.sh"]
