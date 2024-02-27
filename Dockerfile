FROM php:8.0-fpm
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Installation des dépendances PHP (si nécessaire)
# RUN docker-php-ext-install pdo pdo_mysql

COPY . /app

RUN composer install --no-interaction

CMD ["php-fpm"]
