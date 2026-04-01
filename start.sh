#!/bin/sh
echo "Starting AquaFiltra on port ${PORT:-8080}"
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}