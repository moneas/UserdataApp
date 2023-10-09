### instalation
update .env as your mysql configuration
- run : composer install 
    get all laravel module packages
- run : php artisan migrate 
    generate table from migration files
- run : php artisan db:seed --class=CountrySeeder
    generate country records
- run : php artisan serve
    to run laravel app, and open http://127.0.0.1:8000/ in the browser