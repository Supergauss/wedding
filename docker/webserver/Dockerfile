FROM php:8.2-apache

# enable Apache mod-rewrite module
RUN a2enmod rewrite

# make sure to have the latest version of libraries and packages
RUN apt-get update && apt-get install -y git unzip zip npm vim --no-install-recommends && npm install yarn -g

# copy the ./symfony directory to /var/www
ADD --chown=www-data:www-data ./ /var/www/
RUN chown www-data:www-data /var/www/

# remove apache default website
RUN rm -r /etc/apache2/sites-enabled/*
# copy our apache config 
COPY docker/webserver/apache/sites-enabled /etc/apache2/sites-enabled
# copy our php settings
COPY docker/webserver/php/php.ini /usr/local/etc/php/conf.d/extra-php-config.ini

# setup workdirectory
WORKDIR /var/www

# install php extionsions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_mysql bcmath zip intl opcache

# install composer
COPY --from=composer:2.5.5 /usr/bin/composer /usr/local/bin/composer
USER www-data
WORKDIR /var/www
RUN composer install && yarn install && yarn encore prod