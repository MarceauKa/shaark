# Laravel Shaarli

## Requirements

- PHP >= 7.1
- Apache or nginx
- MySQL >= 5.7 or SQLite >= 3

## Installation

```
git clone https://github.com/MarceauKa/laravel-shaarli && cd laravel-shaarli
cp .env.example .env # Then edit it
composer install
npm install && npm run prod
```

Then run `php artisan shaarli:install` (for interactive installation) or `php artisan migrate --seed` (with default data).
Default user is `admin@example.fr` with password `secret`.

## Update

Update the application by running `php artisan shaarli:self-update` or manually:

```bash
php artisan down
git reset --hard
git pull origin master
composer install
php artisan migrate --force -n
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:clear
npm install
npm run prod
php artisan up
```

## Features

- [x] External links
- [x] Internal links
- [x] Private links
- [x] Shared content (Youtube, Soundcloud, Imgur, Videos)
- [x] Rapid sharint through bookmark extension
- [x] Tag system
- [x] Search
- [x] Original Shaarli import
- [x] RSS feed
- [ ] Export
- [ ] Stories
- [ ] i18n

## Screenshots

![Homepage](/resources/screenshots/homepage.png?raw=true "Homepage")
![Form](/resources/screenshots/form.png?raw=true "Add link")
![Import](/resources/screenshots/import.png?raw=true "Import")

## Going live

## Deploying

Check these options before going live.

**Composer flags**

```composer install --no-dev -o```

**.env options**

```
APP_ENV=production
APP_DEBUG=false
APP_URL=http://{your_url}
CACHE_DRIVER=file # or redis
SESSION_DRIVER=file # or redis
QUEUE_DRIVER=sync # or redis
MAIL_DRIVER=smtp
MAIL_FROM_NAME={your_name}
MAIL_FROM_ADDRESS={your_email}
```

**Compiling assets**
```
npm run prod
```

**Artisan routines**
```
php artisan cache:clear
php artisan route:cache
php artisan config:cache
```

## Tests

1. Be sure to have a testing database with `touch database/testing.sqlite` and have composer `require-dev` dependencies installer.
2. Run testing server `php artisan serve --env=testing`.
3. Run tests ```php artisan dusk --env=testing```

## Licence

MIT
