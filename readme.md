## About Laravel

Complete Skeleton API built with Laravel framework, TymonJWT, etc.

## Built With

- [Laravel](https://laravel.com/)
- [Spatie Activity Log](https://github.com/spatie/laravel-activitylog)
- [Spatie Laravel Permission](https://github.com/spatie/laravel-permission)
- [Tymon jwt-auth](http://jwt-auth.readthedocs.io/en/docs/)

## Installation

After downloading the skeleton, run the following commands:

To install the project dependencies:
``` bash
composer install
```

Then, inside project folder:
``` bash
cp .env.example .env
```

To generate Laravel app key:
``` bash
php artisan key:generate
```

To generate JWT secret key:
``` bash
php artisan jwt:secret
```

And to finish, create database structure:
``` bash
php artisan migrate
```

## License

Software licensed under the [MIT license](https://opensource.org/licenses/MIT).
