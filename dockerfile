# Choix de l'image officielle PHP avec Apache
FROM php:8.2-apache

# Active mod_rewrite pour Laravel
RUN a2enmod rewrite

# Installe les extensions PHP nécessaires (exemple: pdo_mysql)
RUN docker-php-ext-install pdo pdo_mysql

# Copie le code de ton projet dans le conteneur
COPY . /var/www/html

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html

# Change le docroot d'Apache vers /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Expose le port 80 (par défaut Apache)
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"]
