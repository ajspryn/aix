
# Laravel Dockerfile for Google Cloud Run
FROM php:8.5-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nginx \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application source
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy nginx config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 8080 for Cloud Run
EXPOSE 8080

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start supervisor (nginx + php-fpm)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Google Cloud Run menggunakan port 8080 secara default
EXPOSE 8080

# Jalankan server internal PHP dan arahkan langsung ke folder 'public'
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]