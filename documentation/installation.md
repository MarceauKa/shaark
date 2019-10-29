# Shaarli - Installation

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Install command](#install-command)
- [Update command](#update-command)
- [Going live](#going-live)

## Requirements

- Linux or macOS env
- PHP >= 7.2
- MySQL >= 5.7 (or SQLite >= 3)
- Node.js >= 6
- Composer
- (Optional) Redis
- (Optional) [youtube-dl](https://github.com/ytdl-org/youtube-dl)

## Installation

### Installation with Git

`git clone https://github.com/MarceauKa/laravel-shaarli && cd laravel-shaarli`

### Composer dependencies

`composer install`

### Config gile 

`cp .env.example .env`

Once created, run `php artisan key:generate` to generate a unique key for you app.  

⚠️ Your `.env` file must be [configured](#configuration) before going further. 

### Symlink

`php artisan storage:link`

### Migrations

Default user is `admin@example.com` with password `secret`.

- With install command:
`php artisan shaarli:install`
- With no data (user must be created manually):
`php artisan migrate`
- With default data:
`php artisan migrate --seed`

Shaarli is now installed! 🎉

## Configuration

### Environment

By default, your `APP_ENV` is set to `local`. Used in production it must be set to `production`.

⚠️ When going to production, install your app first. Then set it to `production` and finally run `composer install --no-dev`.

### Database

Recommended configuration: `mysql`    
Database can use MySQL (default), SQLite or Postgre SQL (see [laravel database configuration](https://laravel.com/docs/6.x/database)).

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### Mail

Recommended configuration: `sendmail` or `smtp`  
Mail can use sendmail (default), smtp, mailgun, postmark or amazon ses (see [laravel mail configuration](https://laravel.com/docs/6.x/mail#driver-prerequisites))

```
MAIL_DRIVER=sendmail
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Laravel Shaarli"
```

### Session

Recommended configuration: `file` or `redis`  
Session can use file (default), cookie, database or redis (see [laravel session configuration](https://laravel.com/docs/6.x/session)).

```
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### Queue (optional)

Recommended configuration: `sync` (local), `redis` (production). Queues are used for [archiving](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving).  
Queue (optional) can use sync (default), redis, database, beanstalkd, amazon sqs (see [laravel queue configuration](https://laravel.com/docs/6.x/queues)).  

```
QUEUE_CONNECTION=sync
```

- Using `sync` all jobs will be processed immediatly and can slow down your app.
- Using `database` requires to run a [worker](https://laravel.com/docs/5.8/queues#supervisor-configuration).
- Using `redis` is the preferred option when installed in production. 

### Redis (optional)

Redis, once configured, is useful for Cache, Session and Queues

```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

When installed and configured you can set cache, session and queues like this:

```
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

## Install command

The install command is useful:
- Init the app with default data
- Customize the default user

⚠ Install command will not work with non-dev composer dependencies installed

Run: `php artisan shaarli:install`

## Update command

Git and composer must be accessible.  
Run: `php artisan shaarli:update`. 

This command is a shortcut for:
```
php artisan down
git reset --hard HEAD
git pull origin master
composer install --no-dev -o
php artisan migrate --force
php artisan storage:link
php artisan optimize
php artisan view:clear
php artisan queue:restart
php artisan up
```

## Going live

When installing to production, check this configuration:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://{your_url}
```

Then run: 
- `composer install --no-dev -o`
- `php artisan optimize`
- `php artisan view:clear`
