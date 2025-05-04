FROM nginx

RUN apt-get update && apt-get install -y \
    snapd

RUN snap install snapd

RUN snap install --classic certbot
RUN certbot --nginx

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
