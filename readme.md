# Laravel Shaarli

It's a **free and open source platform** to host by yourself.

**Shaarli** allows you to **save your web links** (websites, youtube videos, ...), to **share your stories** and 
**manage your web accounts**. 

All of your content can be **private or public** and can be browsed by **tags** or **all-in-one search**.

It's ready to use for **production**. **Laravel Shaarli** is inspired by [Shaarli](https://github.com/shaarli/Shaarli) 
but built with [Laravel](https://github.com/laravel/laravel) and [Vue.js](https://vuejs.org/).

## Summary

- [Requirements](#requirements)
- [Features](#features)
- [Screenshots](#screenshots)
- [Installation](#installation)
- [Archiving](#archiving)
- [Security](#security)
- [Update](#update)
- [Going live](#going-live)
- [Artisan commands](#artisan-commands)
- [Tests](#tests)
- [Licence](#licence)

## Requirements

- Linux or macOS env
- PHP >= 7.2
- MySQL >= 5.7 (or SQLite >= 3)
- Node.js >= 6
- (Optional) Redis
- (Optional) [youtube-dl](https://github.com/ytdl-org/youtube-dl)

## Features

- [x] Links : to save a web content such a website or a youtube video
- [x] Stories : posts with markdown content
- [x] Chests : to save your web accounts
- [x] Rapid sharing through bookmark extension
- [x] Tagging system, search and RSS feeds
- [x] Private content or entirely private
- [x] Original Shaarli import
- [x] Export
- [x] Dark mode
- [x] i18n (english and french)
- [x] **NEW** Archiving
- [x] **NEW** 2-FA with email
- [ ] RSS feed

## Screenshots

![Homepage](/resources/screenshots/home.png?raw=true "Homepage")

## Installation

```
git clone https://github.com/MarceauKa/laravel-shaarli && cd laravel-shaarli
cp .env.example .env # Then edit it
composer install
```

Then run `php artisan shaarli:install` (for interactive installation) or `php artisan migrate --seed` (with default data).
Default user is `admin@example.fr` with password `secret`.

## Archiving

Each link you share can be archived the way you want:

- [youtube-dl](https://github.com/ytdl-org/youtube-dl/) when available on your system, will be used to download media
from youtube, soundcloud, vimeo and [few more sites](http://ytdl-org.github.io/youtube-dl/supportedsites.html).

- [Puppeteer](https://github.com/GoogleChrome/puppeteer) will be used by default to save the webpage as a PDF.

You can adjust archiving configuration in the settings section.

## Security

### Global privacy

If you don't want your content being publicy accessible, you can update this preference once application is installed from settings section.

### 2-FA

You're able to active 2-FA (2 factors authentication). By default 2-FA is disabled but you can update it from your app settings. 
Code length and code expiration are also configurable. **Test if you application can send emails before enabling this feature**.

### Auth monitoring

Shaarli logs all successful and failed auths with their associated devices.

## Update

Update the application by running:

```bash
php artisan down
git reset --hard
git pull origin master
composer install --no-dev -o
php artisan migrate --force -n
php artisan optimize
php artisan view:clear
php artisan queue:restart # if you're using queues
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
QUEUE_CONNECTION=sync # or redis, database
MAIL_DRIVER=smtp
MAIL_FROM_NAME={your_name}
MAIL_FROM_ADDRESS={your_email}
```

**Artisan routines**
```
php artisan optimize
php artisan view:clear
```

## Artisan commands

__TO DO__

## Tests

1. Be sure to have a testing database with `touch database/testing.sqlite` and have composer `require-dev` dependencies installer.
2. Run testing server `php artisan serve --env=testing`.
3. Run tests ```php artisan dusk --env=testing```

## Licence

MIT
