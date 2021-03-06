FROM php:7.0-apache

RUN apt-get update \
 && apt-get install -y git zlib1g-dev libicu-dev libldap2-dev \
 && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
 && docker-php-ext-install zip pdo_mysql intl ldap \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
