# ====== BASE PHP-FPM + NGINX IMAGE ======
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies (Laravel + Nginx)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy semua kode Laravel ke dalam image
COPY . .

# Permission dasar
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install dependency PHP untuk production
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Optional optimasi Laravel (kalau sering ubah route bisa dimatikan)
RUN php artisan config:clear && php artisan cache:clear \
    && php artisan config:cache \
    && php artisan route:cache || true \
    && php artisan view:cache || true

# Hapus default config nginx, ganti dengan config kita
RUN rm /etc/nginx/sites-enabled/default || true \
    && rm /etc/nginx/conf.d/default.conf || true

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Script start: jalankan php-fpm + nginx
COPY docker/nginx/start.sh /start.sh
RUN chmod +x /start.sh

# Render pakai env PORT, kita default-kan ke 10000
ENV PORT=10000

EXPOSE 10000

CMD ["/start.sh"]
