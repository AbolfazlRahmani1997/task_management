FROM php:8.2


WORKDIR /var/www


RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \

RUN docker-php-ext-install pdo pdo_pgsql zip


RUN pecl install redis && \
    docker-php-ext-enable redis

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer


COPY . .
RUN composer require phpredis/phpredis
RUN chown -R www-data:www-data /var/www
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache&&\
    chmod -R 775 /var/www/storage/framework/views


EXPOSE 9000

RUN php artisan migrate

CMD ["php-fpm"]
