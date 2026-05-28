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

# PERBAIKAN: Menambahkan dependensi ekstensi PHP esensial untuk Laravel & Package pihak ketiga
RUN apk add --no-cache \
    unzip \
    libpng-dev \
    libxml2-dev \
    zip \
    curl-dev \
    oniguruma-dev \
    && docker-php-ext-install pdo_mysql bcmath gd ctype curl mbstring xml

# Salin source code yang sudah bersih dari stage vendor
COPY --from=vendor /app /var/www/html

# Atur permission folder storage dan cache agar Laravel bisa menulis log/session
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Environment variables dasar untuk Production
ENV APP_ENV=production
ENV APP_DEBUG=false

# Google Cloud Run akan melempar variabel $PORT (default 8080) ke sini
EXPOSE 8080

# Jalankan server internal PHP yang otomatis mendengarkan Port 8080 secara dinamis
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]