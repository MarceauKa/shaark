# Laravel Shaarli

## Requirements

- PHP >= 7.1
- Apache or nginx
- MySQL >= 5.7 or SQLite >= 3

### Installation

```
git clone https://github.com/MarceauKa/laravel-shaarli && cd laravel-shaarli
cp .env.example .env # Then edit it
composer install
npm install && npm run prod
php artisan migrate --seed
```

The default user is `admin@example.fr` with password `secret`.
