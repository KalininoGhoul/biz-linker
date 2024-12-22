FROM nginx

COPY docker/nginx/templates/default.conf.template /etc/nginx/templates/
