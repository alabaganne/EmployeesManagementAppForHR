#!/bin/bash

# Wait for database to be ready
echo "Waiting for database..."
while ! nc -z db 3306; do
  sleep 1
done
echo "Database is ready!"

# Generate application key if not exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Generate JWT secret if not exists
php artisan jwt:secret --force

# Generate application key if not exists
php artisan key:generate --force

# Run database migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database if tables are empty
echo "Seeding database..."
php artisan db:seed --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the main process
exec "$@"