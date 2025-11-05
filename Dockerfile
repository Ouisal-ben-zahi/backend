# Utiliser PHP 8.0 avec Apache
FROM php:8.0-apache

# Installer extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copier tout le code de ton app dans le conteneur
WORKDIR /var/www/html
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate
RUN php artisan storage:link || true

# Donner les bonnes permissions
RUN chmod -R 775 storage bootstrap/cache

# Configurer Apache pour pointer vers /public
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"]
