FROM php:8.1-apache

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

COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose port 80 for web traffic
EXPOSE 80

# Start Apache and listen for RabbitMQ messages
CMD ["/bin/bash", "-c", "service apache2 start"]