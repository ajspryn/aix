# Stage 1: Build Aset (CSS/JS)
FROM node:18 AS asset-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Aplikasi Utama
FROM php:8.4-fpm-alpine

# Install ekstensi sistem & PHP yang diperlukan Laravel
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl

RUN docker-php-ext-install pdo_mysql bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy file aplikasi
COPY . .
COPY --from=asset-builder /app/public/build ./public/build

# Install dependensi PHP (Production)
RUN composer install --no-dev --optimize-autoloader

# PENTING: Membuat folder storage dan bootstrap/cache agar bisa ditulisi
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    /tmp/views

# Set izin akses (Cloud Run menggunakan user root secara default, tapi folder tetap butuh izin tulis)
RUN chmod -R 777 storage bootstrap/cache /tmp/views

# Copy konfigurasi Nginx (Lihat penjelasan di bawah)
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Ekspos port 8080 (Standar Cloud Run)
EXPOSE 8080

# Jalankan Nginx dan PHP-FPM secara bersamaan
CMD php-fpm -D && nginx -g "daemon off;"
