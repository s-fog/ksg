FROM composer:latest AS composer
FROM php:7.4.15-fpm

RUN apt-get update \
    && apt-get install -y libzip-dev zip libpq-dev libpng-dev webp libmagickwand-dev --no-install-recommends \
    && pecl install redis imagick \
    && docker-php-ext-install pdo pdo_mysql zip pcntl dom \
    && docker-php-ext-enable redis imagick \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./php.ini $PHP_INI_DIR/conf.d/