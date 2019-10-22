# Laravel Shaarli

It's a **free and open source platform** to host by yourself. **Shaarli** allows you to **save your web links** 
(websites, youtube videos, ...), to **share your stories** and **manage your web accounts**. 

All of your content can be **private or public** and can be browsed by **tags** or **all-in-one search**.

It's ready to use for **production**. **Laravel Shaarli** is inspired by [Shaarli](https://github.com/shaarli/Shaarli) 
but built with [Laravel](https://github.com/laravel/laravel) and [Vue.js](https://vuejs.org/).

## Summary

- [Requirements](#requirements)
- [Features](#features)
- [Demo](#demo)
- [Installation](#installation)
- [Archiving](#archiving)
- [Security](#security)
- [Update](#update)
- [Going live](#going-live)
- [Artisan commands](#artisan-commands)
- [Dependencies](#dependencies)
- [Contribute](#contribute)
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
- [x] Private content or entirely private (with temp sharing)
- [x] Original Shaarli import
- [x] Export
- [x] Dark mode
- [x] i18n (EN, FR and DE)
- [x] Archiving
- [x] 2-FA with email
- [x] Multi-users
- [x] **NEW** RSS feed

## Demo

![Homepage](/resources/screenshots/home.jpg?raw=true "Homepage")

A public demo is available at [https://shaarli.mka.ovh](https://shaarli.mka.ovh). Credentials are **admin@example.com** and **secret**. 
This demo is resetted hourly.

## Installation

```
git clone https://github.com/MarceauKa/laravel-shaarli && cd laravel-shaarli
cp .env.example .env # Then edit it
composer install
```

Then run `php artisan shaarli:install` (for interactive installation) or `php artisan migrate --seed` (with default data).
Default user is `admin@example.com` with password `secret`.

### Additional configuration

Laravel Shaarli is built with [Laravel 6](https://laravel.com/docs/6.x/installation). There's many ways to configuration database, session, mail and queue:
- Database can use MySQL (default), SQLite or Postgre SQL (see [database configuration](https://laravel.com/docs/6.x/database))
- Session can use file (default), cookie, database or redis (see [session configuration](https://laravel.com/docs/6.x/session))
- Mail can use sendmail (default), smtp, mailgun, postmark or amazon ses (see [mail configuration](https://laravel.com/docs/6.x/mail#driver-prerequisites))
- Queue (optional) can use sync (default), redis, database, beanstalkd, amazon sqs (see [queue configuration](https://laravel.com/docs/6.x/queues))   

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

### Chests encryption

Since `1.2.9`, all chests data are encrypted in your database using AES-256-CBC and your app key.

### Multi-users

Others users can be admin or non-admin. Admin users are like the main user and have an access to the entire content. 
Non-admin users can't access the settings section and can only see their own private content.

## Update

Update the application by running or use the `php artisan shaarli:update`.

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

### Install command

`php artisan shaarli:install`

This command will install default data (seeder) or ask you for the default user.

### Update command

`php artisan shaarli:update`

This command will try to [update](#update) Shaarli. `Git` and `Composer` must be accessible from your env.

### Encrypt and decrypt

Encryption is made on the fly for your chests, but you can manually encrypt or decrypt them 
by running `php artisan shaarli:chests:encrypt` or `php artisan shaarli:chests:decrypt`.

## Dependencies

Our dependencies with link to their documentation and why we use it.

### PHP

- [laravel-auth-checker](https://github.com/404labfr/laravel-auth-checker) is used to keep a trace of auth attempts
- [scout](https://laravel.com/docs/6.x/scout) is used for full-text search in database
- [excel](https://github.com/Maatwebsite/Laravel-Excel) is used to generate exports as xlsx or csv
- [valuestore](https://github.com/spatie/valuestore) is used for application settings
- [dom-crawler](https://github.com/symfony/dom-crawler) is used to read metadata from posted links
- [puphpeteer](https://github.com/nesk/puphpeteer/) is used to save your links as PDF using a chrome browser
- [youtube-dl-php](https://github.com/norkunas/youtube-dl-php) is a bridge to youtube-dl to save you links (youtube, soundcloud, ...) as a local copy

### JS

- [bootstrap](http://getbootstrap.com) is used as CSS framework
- [vue](https://github.com/vuejs/vue) is used as JS framework 
- [axios](https://github.com/axios/axios) is for http requests
- [tui.editor](https://github.com/nhn/toast-ui.vue-editor) is used for both editing and viewing markdown
- [vue-multiselect](https://vue-multiselect.js.org/) is used for the tags system
- [vue-toasted](https://github.com/shakee93/vue-toasted) is used for in app notifications
- [vuedraggable](https://www.npmjs.org/package/vuedraggable) is used to reorder items in chests
- [vue-clickaway](https://github.com/simplesmiler/vue-clickaway) is used to close search bar when clicked away

## Contribute

All contribution are welcome! Please use the `dev` branch for your pull requests.  
If you make changes to JS, don't compile assets in production, I'll manually compile them when merging for security reasons.

## Tests

1. Be sure to have a testing database with `touch database/testing.sqlite` and have composer `require-dev` dependencies installer.
2. Run testing server `php artisan serve --env=testing`.
3. Run tests ```php artisan dusk --env=testing```

## Licence

MIT
