#!/bin/bash

# Laravel Project Installation
echo "Laravel Project Installation:";

# 1. Install composer.json via Composer
composer install

# 2. Move env to .env
mv env .env

# 3. Generate Laravel Key
php artisan key:generate

# 4. Clear Cache
php artisan cache:clear

# 5. Clear Config
php artisan config:clear

# 6. Dump Composer Autoload
composer dump-autoload

# 7. Change mode folder ./vendor ./bootstrap ./database & ./storage to 777 (Recursive)
chmod -R 777 ./vendor ./bootstrap ./database ./storage

# 8. Run Test
./vendor/bin/phpunit

# 9. Run Laravel on http://127.0.0.1:8000
php artisan serve