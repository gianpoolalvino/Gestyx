FROM php:8.3-apache

RUN apt-get update && apt-get install -y libicu-dev libzip-dev libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install mysqli intl zip gd exif

COPY docker/gestyx.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

COPY docker/php.ini /usr/local/etc/php/conf.d/gestyx.ini