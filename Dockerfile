FROM php:7.0.4-apache

RUN apt-get update && apt-get install curl -y

COPY config/vhosts/*.conf /etc/apache2/sites-enabled/
COPY config/apache2.conf /etc/apache2/apache2.conf
COPY www /var/www/html

RUN mkdir /cache && chown www-data:www-data -R /cache
VOLUME /cache

RUN cd /var/www/html && curl -sS https://getcomposer.org/installer | php && php composer.phar install

EXPOSE 80
EXPOSE 443
