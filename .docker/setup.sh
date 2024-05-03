#!/bin/bash
# Creación variables de ambiente
cp .env.example .env

# Descargue dependencias composer
composer install

# Creación laravel key
php artisan key:generate

# Ejecución de migraciones y seeders
php artisan migrate --seed
