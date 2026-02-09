FROM php:8.2-apache

# 1. Install System Dependencies & PHP Extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Config Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# 3. Install Composer dengan cara menyalin dari image official
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Install Node.js (untuk Vite/Tailwind/Alpine)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

WORKDIR /var/www/html

# Copy Config PHP Custom
COPY ./php-custom.ini /usr/local/etc/php/conf.d/php-custom.ini

# Copy Source Code
COPY . .

# Set Permission agar bisa diakses
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache