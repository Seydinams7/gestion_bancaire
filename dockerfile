FROM php:8.2-cli

# Extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Copie du .env
COPY .env.example .env

# Install des dépendances Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Génère la clé Laravel
RUN php artisan key:generate

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql


# Run les migrations (⚠️ avec `--force` sinon Laravel refuse en prod)
RUN php artisan migrate --force || true

RUN chmod -R 775 storage bootstrap/cache

# Expose le port
EXPOSE 8000
php artisan migrate --force

# Lancer le serveur Laravel (si tu n'utilises pas Apache/Nginx)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
