# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala las extensiones necesarias

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install PostgreSQL server
RUN apt-get update && apt-get install -y postgresql-$POSTGRES_VERSION

# Set the Apache document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache modules
RUN a2enmod rewrite