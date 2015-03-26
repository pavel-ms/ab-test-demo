#!/bin/bash

service php-fpm start;
#service memcached start;
service redis start;

cp /var/www/ab-test/puphpet/files/nginx.conf /etc/nginx/nginx.conf
#cp /var/www/ab-test/puphpet/files/host.conf /etc/nginx/sites-available/host.conf
ln -s /var/www/ab-test/puphpet/files/host.conf /etc/nginx/sites-enabled/host.conf
service nginx restart

# websocket app start by this way
# su vagrant -c "forever start /var/www/cservice/web/serverJs/main.js --env test --database test --port 56444"