FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install intl zip pdo_mysql \
    && docker-php-ext-install sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 9000

CMD ["php-fpm"]
