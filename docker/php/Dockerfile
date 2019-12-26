FROM php:7.4.1-fpm

MAINTAINER Shpak

RUN apt-get update && apt-get install -y \
    nano \
    git \
    zip \
    zlib1g-dev \
    libnss3-dev \
    libzip-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www/app
