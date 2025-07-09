FROM php:8.2-apache

# PostgreSQL için PDO eklentilerini kur
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Hataları görebilmek için opsiyonel:
COPY php.ini /usr/local/etc/php/

# Apache mod_rewrite aktif et (isteğe bağlı)
RUN a2enmod rewrite
