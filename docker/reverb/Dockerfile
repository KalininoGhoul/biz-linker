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

COPY docker/app/config/php.ini $PHP_INI_DIR/php.ini

RUN useradd -m web

RUN chown -R web:web /var/log

RUN apt-get update && apt-get install -y \
    libuv1 \
    libuv1-dev

RUN docker-php-ext-install pcntl

RUN pecl install -f uv-0.3.0 && \
    docker-php-ext-enable uv

USER web

COPY ./docker/reverb/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080

ENTRYPOINT ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
