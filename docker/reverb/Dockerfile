FROM biz-linker-php

WORKDIR /var/www/html/

USER root

RUN apt-get update && apt-get install -y \
    libuv1 \
    libuv1-dev

RUN docker-php-ext-install pcntl

RUN pecl install uv-0.3.0 && \
    docker-php-ext-enable uv

USER web

COPY docker/reverb/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080

ENTRYPOINT ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
