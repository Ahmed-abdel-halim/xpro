#!/usr/bin/env bash
# exit on error
set -o errexit

echo "--- Running Composer ---"
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "--- Running NPM ---"
npm install
npm run build

echo "--- Caching config and routes ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Running Migrations ---"
php artisan migrate --force

echo "--- Linking Storage ---"
php artisan storage:link
