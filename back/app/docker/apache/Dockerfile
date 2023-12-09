# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala las extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instala Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf


# Habilita módulos de Apache
RUN a2enmod rewrite
RUN a2enmod headers
