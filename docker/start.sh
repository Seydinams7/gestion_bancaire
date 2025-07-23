#!/bin/bash

# Attendre que la base de données soit prête
echo "Waiting for database to be ready..."
sleep 10

# Générer la clé d'application si elle n'existe pas
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Exécuter les migrations
echo "Running database migrations..."
php artisan migrate --force

# Exécuter les seeders
echo "Running database seeders..."
php artisan db:seed --force

# Optimiser l'application pour la production
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer Apache
echo "Starting Apache..."
apache2-foreground

