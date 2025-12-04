# Gunakan PHP 8.3 FPM (cocok buat Laravel 10/11)
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependency sistem untuk Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip \
    && rm -rf /var/lib/apt/lists/*

# (opsional) install composer di container
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Permission basic
RUN chown -R www-data:www-data /var/www/html

# Expose port php-fpm (Nginx akan connect ke sini)
EXPOSE 9000

# PENTING: jalankan php-fpm sebagai proses utama
CMD ["php-fpm"]
