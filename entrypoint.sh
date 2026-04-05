#!/bin/bash

echo "==> Démarrage de l'application Laravel..."

# Permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Lien symbolique storage
php artisan storage:link

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations
php artisan migrate --force

# Démarrage serveur
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
