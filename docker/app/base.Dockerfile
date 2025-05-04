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
    libzip-dev \
    supervisor

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
    iconv \
    bcmath

RUN pecl install redis && \
    docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/app/config/php.ini $PHP_INI_DIR/php.ini
COPY docker/app/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/app/config/entrypoint.sh /entrypoint.sh

RUN useradd -m web

RUN chown -R web:web /var/log

USER web

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
