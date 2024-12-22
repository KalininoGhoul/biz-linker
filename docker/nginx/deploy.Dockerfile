FROM nginx

RUN rm /etc/nginx/templates
COPY docker/nginx/templates /etc/nginx/templates
