FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Enable Apache rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend (Vite)
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Apache: serve Laravel public folder + Render port
RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-enabled/000-default.conf \
    && sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf \
    && sed -i 's/:80/:${PORT}/g' /etc/apache2/sites-enabled/000-default.conf

# Copy startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]
