FROM nginx

RUN apt-get update && apt-get install -y \
    python3  \
    python3-venv  \
    libaugeas0 \
    cron

RUN python3 -m venv /opt/certbot/
RUN /opt/certbot/bin/pip install --upgrade pip
RUN /opt/certbot/bin/pip install certbot certbot-nginx

COPY docker/nginx/nginx-ci.conf /etc/nginx/nginx.conf
COPY backend/public /var/www/html/public
RUN ln -sf /var/www/html/storage/app/public /var/www/html/public/storage

RUN (crontab -l && echo "0 0,12 * * * root /opt/certbot/bin/python -c 'import random; import time; time.sleep(random.random() * 3600)' && /opt/certbot/bin/certbot renew -q && nginx -s reload") | crontab -
