# Booking System
```git clone https://github.com/almamuncsit/booking-system.git```

## On the terminal or command prompt to the the project folder and run the following composer command
```composer install```

## Configure database
There is a `.env` file on the root folder open the `.env` file and update database information.
```
DB_DATABASE=booking
DB_USERNAME=root
DB_PASSWORD=
```
Update Database name username and password or create database following this information.

## Configure Redis for Caching
Update the following ENV variable for redis caching. Make sure that your machibe has redis installed. 
```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis
```

## Run migrations for creating database
`php artisan migrate`

## Create some fake data using seeder
`php artisan db:seed`

## Run the application
Run the following command on the project root directory.

```php -S localhost:8000 -t public```
 