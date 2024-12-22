FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    redis-tools \
    git \
    libpq-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libonig-dev \
    libzip-dev

RUN docker-php-ext-install pdo \
    pdo_pgsql  \
    pgsql \
    ctype \
    curl \
    intl \
    mbstring \
    opcache \
    phar \
    zip \
    iconv

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/app/config/php.ini /etc/php/conf.d/custom.ini

RUN useradd -m web

COPY --chown=web:web backend/ /var/www/html/

RUN composer install --optimize-autoloader --no-interaction --no-progress && \
    php artisan migrate --force && \
    php artisan optimize:clear && \
    php artisan storage:link

USER web

EXPOSE 9000

ENTRYPOINT ["php-fpm", "-F"]
