cat <<EOF > Dockerfile
FROM php:8.4-apache

# 1. Install dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel & SQLite
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd

# 2. Aktifkan mod_rewrite Apache (Penting untuk routing Laravel)
RUN a2enmod rewrite

# 3. Set direktori kerja
WORKDIR /var/www/html
COPY . .

# 4. Install Composer (Jika belum ada vendor, jika sudah ada lewati)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 5. Konfigurasi Apache untuk Laravel (Root ke folder /public)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 6. Set izin folder (CRITICAL untuk SQLite dan Laravel)
# Pastikan file database sqlite Anda juga bisa ditulis
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Jika file database Anda ada di folder database/
RUN touch database/database.sqlite && chmod 777 database/database.sqlite && chmod 777 database/

EXPOSE 8080
EOF
