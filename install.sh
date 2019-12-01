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

# 7. Change mode folder ./vendor ./bootstrap ./database, ./storage, and ./public to 777 (Recursive)
chmod -R 777 ./vendor ./bootstrap ./database ./storage ./public

# 8. Run Test
./vendor/bin/phpunit

# Laravel Project Installation
echo "Installation is done!";