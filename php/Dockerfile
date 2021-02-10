FROM composer:latest AS composer
FROM php:7.4.15-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./php.ini /usr/local/etc/php/custom.d/

RUN apt-get update
RUN apt-get install -y libzip-dev zip libpq-dev libpng-dev webp libmagickwand-dev --no-install-recommends
RUN pecl install redis imagick
RUN docker-php-ext-install pdo pdo_mysql zip pcntl
RUN docker-php-ext-enable redis imagick
