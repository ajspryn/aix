# Stage 1: Install semua dependensi Laravel menggunakan Composer
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-progress --no-scripts

COPY . .
RUN composer dump-autoload --optimize

# Stage 2: Runtime menggunakan PHP 8.4 Resmi berbasis Alpine
FROM php:8.4-alpine AS runtime
WORKDIR /var/www/html

# Install ekstensi PHP yang wajib dibutuhkan oleh Laravel
RUN apk add --no-cache \
    unzip \
    libpng-dev \
    libxml2-dev \
    zip \
    curl-dev \
    oniguruma-dev \
    && docker-php-ext-install pdo_mysql bcmath gd ctype curl mbstring xml

# Salin source code dari stage vendor
COPY --from=vendor /app /var/www/html

# PERBAIKAN SQLITE & PERMISSIONS:
# Membuat file database dan memastikan server (www-data) bisa membaca folder public & storage
RUN touch /var/www/html/database.sqlite \
    && mkdir -p storage bootstrap/cache \
    && chmod -R 775 /var/www/html \
    && chown -R www-data:www-data /var/www/html

# Environment variables dasar untuk Production dengan SQLite
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/var/www/html/database.sqlite

# Google Cloud Run menggunakan port 8080 secara default
EXPOSE 8080

# Jalankan server internal PHP dan arahkan langsung ke folder 'public'
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]