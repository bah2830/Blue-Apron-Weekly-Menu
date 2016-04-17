FROM php:7.0.4-apache

COPY config/vhosts/*.conf /etc/apache2/sites-enabled/
COPY config/apache2.conf /etc/apache2/apache2.conf
COPY www /var/www/html

RUN chown www-data:www-data -R /var/www
RUN mkdir /cache && chown www-data:www-data -R /cache

VOLUME /cache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

USER www-data
WORKDIR "/var/www/html"

RUN composer install --prefer-source --no-interaction

USER root

EXPOSE 80
EXPOSE 443
