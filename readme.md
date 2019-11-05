# Laravel Shaarli

**Laravel Shaarli is a self-hosted platform to keep and share your content: web links, posts, passwords and pictures.**

All of your data can be **private, public or both** and can be browsed by **tags** or **all-in-one search**.

**Laravel Shaarli** is production ready, inspired by [Shaarli](https://github.com/shaarli/Shaarli) 
and built with [Laravel](https://github.com/laravel/laravel) and [Vue.js](https://vuejs.org/).

## Summary

- [Features](#features)
- [Demo](#demo)
- [Installation](#installation)
- [Archiving](#archiving)
- [Contribute](#contribute)
- [Security](#security)
- [Dependencies](#dependencies)
- [Tests](#tests)
- [Licence](#licence)

## Features

- [x] Links : to keep your bookmarks
- [x] Stories : posts with markdown flavored content
- [x] Chests : to save your passwords
- [x] Albums : to host your pictures
- [x] Rapid sharing extension and progressive web app 
- [x] Tagging system, search and RSS feeds
- [x] Private content or entirely private (with temp sharing)
- [x] Export / Import (even original Shaarli)
- [x] Theming (dark mode, background)
- [x] i18n (🇬🇧, 🇫🇷, 🇩🇪, 🇯🇵)
- [x] [Archiving](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md) (as pdf, as media)
- [x] DB encryption, 2-FA, Multi-users, [backup](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/backup.md)

## Demo

![Homepage](/resources/screenshots/home.jpg?raw=true "Homepage")

A public demo is available at [https://shaarli.mka.ovh](https://shaarli.mka.ovh). Credentials are **admin@example.com** and **secret**. 
This demo is resetted hourly.

## [Installation](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/installation.md)

See the extensive [installation documentation](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/installation.md).

## [Archiving](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md)

Each link you share can be archived the way you want:

- [youtube-dl](https://github.com/ytdl-org/youtube-dl/) when available on your system, will be used to download media
from youtube, soundcloud, vimeo and [few more sites](http://ytdl-org.github.io/youtube-dl/supportedsites.html).

- [Puppeteer](https://github.com/GoogleChrome/puppeteer) will be used by default to save the webpage as a PDF.

Learn more in the [archiving documentation](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md).

## Contribute

### Features and bugs

All contributions are welcome! Please use the `dev` branch for your pull requests.  
If you make changes to JS, don't compile assets in production, I'll manually compile them when merging for security reasons.

### Translation

Shaarli is actually available in **English**, **French** and **German**. Feel free to make a pull request to add or update a localization. 
You can see laravel base localizations [on this repo](https://github.com/caouecs/Laravel-lang).

### Your Shaarli

You host your own Shaarli public instance and you want to share it with other Shaarliers? 
You can make a pull request to add it to our public listing located at [shaarlies.md](https://github.com/MarceauKa/laravel-shaarli/blob/dev/shaarlies.md). 

## Security

If you find any **security issues**, please send me an email (can be found in composer.json).

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

## Dependencies

Our dependencies with link to their documentation and why we use it.

### PHP

- [laravel-auth-checker](https://github.com/404labfr/laravel-auth-checker) is used to keep a trace of auth attempts
- [scout](https://laravel.com/docs/6.x/scout) is used for full-text search in database
- [excel](https://github.com/Maatwebsite/Laravel-Excel) is used to generate exports as xlsx or csv
- [valuestore](https://github.com/spatie/valuestore) is used for application settings
- [dom-crawler](https://github.com/symfony/dom-crawler) is used to read metadata from posted links
- [puphpeteer](https://github.com/nesk/puphpeteer/) is used to [save your links as PDF](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md) using a chrome browser
- [youtube-dl-php](https://github.com/norkunas/youtube-dl-php) is a bridge to youtube-dl to [save your links](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md) (youtube, soundcloud, ...) as a local copy
- [laravel-backup](https://github.com/spatie/laravel-backup) is used for... [backups](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/backup.md) !

### JS

- [bootstrap](http://getbootstrap.com) is used as CSS framework
- [vue](https://github.com/vuejs/vue) is used as JS framework 
- [axios](https://github.com/axios/axios) is for http requests
- [tui.editor](https://github.com/nhn/toast-ui.vue-editor) is used for both editing and viewing markdown
- [vue-multiselect](https://vue-multiselect.js.org/) is used for the tags system
- [vue-toasted](https://github.com/shakee93/vue-toasted) is used for in app notifications
- [vuedraggable](https://www.npmjs.org/package/vuedraggable) is used to reorder items in chests
- [vue-clickaway](https://github.com/simplesmiler/vue-clickaway) is used to close search bar when clicked away

## Tests

1. Be sure to have a testing database with `touch database/testing.sqlite` and have composer `require-dev` dependencies installer.
2. Run testing server `php artisan serve --env=testing`.
3. Run tests ```php artisan dusk --env=testing```

## Licence

MIT
