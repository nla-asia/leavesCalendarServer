### Leaves Calendar REST API
composer install
cp .env.example .env
Enter correct information of your mysql server credentials
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan serve


