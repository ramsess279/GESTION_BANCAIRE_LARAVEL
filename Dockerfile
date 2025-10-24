# Étape 1: Build des dépendances PHP
FROM composer:latest AS composer-build

WORKDIR /app

# Copier les fichiers de dépendances
COPY composer.json composer.lock ./

# Installer les dépendances PHP sans scripts post-install
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Étape 2: Image finale pour l'application
FROM php:8.3-fpm-alpine3.20

# Installer les extensions PHP nécessaires et mettre à jour les packages
RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
    postgresql-dev \
    libpq \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/cache/apk/*

# Créer un utilisateur non-root
RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les dépendances installées depuis l'étape de build
COPY --from=composer-build /app/vendor ./vendor

# Copier le reste du code de l'application
COPY . .

# Créer les répertoires nécessaires et définir les permissions
RUN mkdir -p storage/framework/{cache,data,sessions,testing,views} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R laravel:laravel /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Créer un fichier .env minimal pour le build
RUN echo "APP_NAME=Laravel" > .env && \
    echo "APP_ENV=production" >> .env && \
    echo "APP_KEY=" >> .env && \
    echo "APP_DEBUG=false" >> .env && \
    echo "APP_URL=http://localhost" >> .env && \
    echo "" >> .env && \
    echo "LOG_CHANNEL=stack" >> .env && \
    echo "LOG_LEVEL=error" >> .env && \
    echo "" >> .env && \
    echo "DB_CONNECTION=pgsql" >> .env && \
    echo "DB_HOST=dpg-d3tbv33ipnbc7384g2kg-a" >> .env && \
    echo "DB_PORT=5432" >> .env && \
    echo "DB_DATABASE=gestion_bancaire_fqdq" >> .env && \
    echo "DB_USERNAME=gestion_bancaire_fqdq_user" >> .env && \
    echo "DB_PASSWORD=aZueE4EOiuxRYSpp0EcGoMeAMgs60MAS" >> .env && \
    echo "" >> .env && \
    echo "CACHE_DRIVER=file" >> .env && \
    echo "SESSION_DRIVER=file" >> .env && \
    echo "QUEUE_CONNECTION=sync" >> .env

# Changer les permissions du fichier .env pour l'utilisateur laravel
RUN chown laravel:laravel .env

# Générer la clé d'application et optimiser
USER laravel
RUN php artisan key:generate --force && \
    php artisan config:cache && \
    php artisan route:cache
USER root

# Copier le script d'entrée
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Passer à l'utilisateur non-root
USER laravel

# Exposer le port
EXPOSE 8000

# Utiliser le script d'entrée comme point d'entrée
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]