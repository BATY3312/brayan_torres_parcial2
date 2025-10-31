# Usar imagen base de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar los archivos de la aplicación al directorio de Apache
COPY . /var/www/html/

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Habilitar mod_rewrite para URLs limpias
RUN a2enmod rewrite

# Configurar Apache para permitir .htaccess
RUN sed -i 's/<Directory \/var\/www\/html>/<Directory \/var\/www\/html>\n    AllowOverride All/' /etc/apache2/sites-enabled/000-default.conf

# Exponer el puerto 80
EXPOSE 80

# El comando CMD por defecto de la imagen es apache2-foreground
