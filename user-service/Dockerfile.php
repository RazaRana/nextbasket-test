FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    supervisor \
    librabbitmq-dev \
    && docker-php-ext-install intl zip pdo_mysql \
    && docker-php-ext-install sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy Supervisor configuration file
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start Supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
