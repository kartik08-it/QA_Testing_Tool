#!/bin/sh

echo "===================================="
echo "Starting Laravel application (Render)"
echo "===================================="

mkdir -p storage/logs bootstrap/cache

# Fail-safe: ensure storage permissions
echo "Fixing permissions..."
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

# Run Laravel commands safely
echo "Running Laravel setup commands..."

php artisan key:generate --force || true
php artisan migrate --force || true
php artisan storage:link || true

php artisan optimize:clear || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "Laravel setup complete."
echo "Starting Apache..."

# IMPORTANT: this must be last and must NOT exit
exec apache2-foreground
