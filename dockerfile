# Dockerfile

FROM php:8.2-cli

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev

# Installer les extensions PHP, y compris PostgreSQL
RUN docker-php-ext-install pdo_pgsql pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Copier Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier le code source dans le conteneur
COPY . .

# Installer les dépendances PHP via Composer
RUN composer install --no-interaction

# Exposer le port 8000 pour php artisan serve
EXPOSE 8000

# Lancer le serveur Laravel
CMD php -S 0.0.0.0:8000 -t public
