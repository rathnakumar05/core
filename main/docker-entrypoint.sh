#!/bin/bash

wg-quick up wg0
chown -R www-data:www-data /var/www/html
sleep 30
a2ensite 000-default-le-ssl.conf
a2enmod ssl
service apache2 reload
/usr/bin/php /var/www/html/artisan migrate

/usr/bin/python3 /root/systemd/performance.py &
/usr/sbin/apache2ctl -D FOREGROUND

