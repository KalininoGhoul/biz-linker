FROM biz-linker-php

COPY --chown=web:web backend/ /var/www/html/

USER web
