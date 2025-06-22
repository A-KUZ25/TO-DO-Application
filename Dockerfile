FROM php:8.3-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Установка Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /var/www

# Копирование проекта
COPY . .
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Установка зависимостей Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Открытие порта PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
