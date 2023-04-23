FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    librabbitmq-dev \
    && docker-php-ext-install intl zip  \
    && docker-php-ext-install sockets \
    && docker-php-ext-install intl zip \
    && pecl install amqp \
    && docker-php-ext-enable amqp sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 9001

CMD ["php", "bin/console", "app:user-created-event-consumer"]
