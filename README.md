create .env
composer install 
npm install
php artisan key:generate
php artisan migrate --seed
