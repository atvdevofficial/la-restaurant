# La Restaurant
A food booking web application build with Laravel and VueJs.

## Installation
#### Prerequisites
 + PHP 7.4
 + MySQL Database
 + Composer
 + NodeJs

#### Installation
```bash
# First clone or download repository

# Inside the project directory
# Run "composer install"
composer install

# Run "npm install"
npm install

# Create .env file and generate key
cp .env.example .env
php artisan key:generate

# Inside the .env file created updated the 
# following variables using your own keys:
GOOGLE_API_KEY=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Run server (localhost | 127.0.0.1)
php artisan serve

# On another terminal, run command for Laravel Queues
# Laravel Queues is used in event broadcasting (e.g. Notifications)
php artisan queue:work
```

## Contacts
+ [atvdev](https://atvdev.netlify.com)
