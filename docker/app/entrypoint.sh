#!/bin/sh
set -e

cd /var/www/html

echo "📦 Menunggu database siap..."

# Tunggu sampai MySQL bisa diakses
until php -r "try {
    new PDO(
      'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
      getenv('DB_USERNAME'),
      getenv('DB_PASSWORD')
    );
    echo 'DB OK';
} catch (Exception \$e) {
    exit(1);
}" >/dev/null 2>&1; do
  echo "⏳ DB belum siap, retry dalam 2 detik..."
  sleep 2
done

echo "✅ Database siap."

# Install dependency Laravel kalau vendor belum ada
if [ ! -d "vendor" ]; then
  echo "🔧 Menjalankan composer install..."
  composer install --no-interaction
fi

# Jalankan migrasi (kalau gagal, jangan matikan container)
echo "🗃  Menjalankan migrasi..."
php artisan migrate --force || echo "❗ Migrasi gagal, cek lagi nanti."

# Pastikan permission storage & cache (kalau di Linux server)
if [ -d "storage" ]; then
  chmod -R 775 storage bootstrap/cache || true
fi

echo "🚀 Menjalankan PHP-FPM..."
php-fpm
