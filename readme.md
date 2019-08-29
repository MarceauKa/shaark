# Laravel Shaarli

It's a **free and open source platform** to host by yourself.

**Shaarli** allows you to **save your web links** (websites, youtube videos, ...), to **share your stories** and 
**manage your web accounts**. All of your content can be **private or public** and can be browsed by **tags** or **all-in-one search**.

It's ready to use for **production**. **Laravel Shaarli** is inspired by [Shaarli](https://github.com/shaarli/Shaarli) 
but built with [Laravel](https://github.com/laravel/laravel) and [Vue.js](https://vuejs.org/).

## Requirements

- PHP >= 7.1
- Apache or nginx
- MySQL >= 5.7 or SQLite >= 3

## Features

- [x] Links : to save a web content such a website or a youtube video
- [x] Stories : posts with markdown content
- [x] Chests : to save your web accounts
- [x] Rapid sharing through bookmark extension
- [x] Tagging system, search and RSS feeds
- [x] Private content or entirely private
- [x] Original Shaarli import
- [x] RSS feed
- [x] Export
- [x] Dark mode
- [x] i18n (english and french)

## Screenshots

![Homepage](/resources/screenshots/homepage.png?raw=true "Homepage")
![Link](/resources/screenshots/link.png?raw=true "Add link")
![Story](/resources/screenshots/story.png?raw=true "Add story")

## Installation

```
git clone https://github.com/MarceauKa/laravel-shaarli && cd laravel-shaarli
cp .env.example .env # Then edit it
composer install
npm install && npm run prod
```

Then run `php artisan shaarli:install` (for interactive installation) or `php artisan migrate --seed` (with default data).
Default user is `admin@example.fr` with password `secret`.

## System-wide private content

If you don't want your content being publicy accessible, update the `.env` file and set `APP_PRIVATE` to `true`. 
Alternatively, you can update this preference once application is installed from settings section. 

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

## Going live

Check these options before going live.

**Composer flags**

```composer install --no-dev -o```

**.env options**

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://{your_url}
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
