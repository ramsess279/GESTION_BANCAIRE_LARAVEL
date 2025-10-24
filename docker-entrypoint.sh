#!/bin/sh

# Définir le port par défaut si PORT n'est pas défini
PORT=${PORT:-8000}

# Exécuter les migrations (optionnel, décommentez si nécessaire)
# php artisan migrate --force

# Démarrer le serveur Laravel
exec php artisan serve --host=0.0.0.0 --port=$PORT