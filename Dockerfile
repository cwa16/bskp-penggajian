# Use official PHP image with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring gd xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set file permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]
