<p align="center">
  <img width="256" height="256" src="https://raw.githubusercontent.com/MarceauKa/shaark/dev/public/images/logo-shaark.png" alt="Logo Shaark" />
</p>

**Shaark is a self-hosted platform to keep and share your content: web links, posts, passwords and pictures.**

All of your data can be **private, public or both** and can be browsed by **tags** or **all-in-one search**.

**Shaark** is production ready, inspired by [Shaarli](https://github.com/shaarli/Shaarli), built with [Laravel](https://github.com/laravel/laravel) and [Vue.js](https://vuejs.org/).

## Summary

[Features](#features) / [Demo](#demo) / [Documentation](#documentation) / [Contribute](#contribute) / [Security](#security) / [Tests](#tests) / [Licence](#licence)

## Features

- [x] Links : to keep your bookmarks
- [x] Stories : posts with markdown flavored content
- [x] Chests : to save your passwords
- [x] Albums : to host your pictures
- [x] Rapid sharing extension and **P**rogressive **W**eb **A**pp 
- [x] Tagging system, walls, search and RSS feeds
- [x] Private content or entirely private (with temp sharing)
- [x] Theming (dark mode, background)
- [x] i18n (🇬🇧, 🇫🇷, 🇩🇪, 🇯🇵)
- [x] [Archiving](https://github.com/MarceauKa/shaark/blob/dev/documentation/archiving.md) (as pdf, as media)
- [x] DB encryption, 2-FA, Multi-users, [backup](https://github.com/MarceauKa/shaark/blob/dev/documentation/backup.md)

## Demo

![Homepage](/resources/screenshots/home.jpg?raw=true "Homepage")

A public demo is available at [https://shaark.mka.ovh](https://shaark.mka.ovh). Credentials are **admin@example.com** and **secret**. 
This demo is resetted hourly.

## Documentation

- [Installation](https://github.com/MarceauKa/shaark/blob/dev/documentation/installation.md): How to install Shaark
- [Troubleshooting](https://github.com/MarceauKa/shaark/blob/dev/documentation/troubleshooting.md): Common issues
- [Changelog](https://github.com/MarceauKa/shaark/blob/dev/changelog.md): Extensive changelog
- [Archiving](https://github.com/MarceauKa/shaark/blob/dev/documentation/archiving.md): How to run PDF and Media archiving
- [Backup](https://github.com/MarceauKa/shaark/blob/dev/documentation/backup.md): How to set up automatic backup
- [Comments](https://github.com/MarceauKa/shaark/blob/dev/documentation/comments.md): How comment system work
- [Dependencies](https://github.com/MarceauKa/shaark/blob/dev/documentation/dependencies.md): Dependencies used by Shaark

## Contribute

### Features and bugs

All contributions are welcome! Please use the `dev` branch for your pull requests.  
If you make changes to JS, don't compile assets in production, I'll manually compile them when merging for security reasons.

### Translation

Shaark is actually available in 🇬🇧, 🇫🇷, 🇩🇪, 🇯🇵. Feel free to make a pull request to add or update a localization. 
You can see laravel base localizations [on this repo](https://github.com/caouecs/Laravel-lang). 

## Security

If you find any **security issues**, please send me an email (can be found in composer.json).

### Global privacy

If you don't want your content being publicy accessible, you can update this preference once application is installed from settings section.

### 2-FA

You're able to active 2-FA (2 factors authentication). By default 2-FA is disabled but you can update it from your app settings. 
Code length and code expiration are also configurable. **Test if you application can send emails before enabling this feature**.

### Auth monitoring

Shaark logs all successful and failed auths with their associated devices.

### Chests encryption

Since `1.2.9`, all chests data are encrypted in your database using AES-256-CBC and your app key.

### Multi-users

Others users can be admin or non-admin. Admin users are like the main user and have an access to the entire content. 
Non-admin users can't access the settings section and can only see their own private content.

## Tests

1. Be sure to have a testing database with `touch database/testing.sqlite` and have composer `require-dev` dependencies installer.
2. Run testing server `php artisan serve --env=testing`.
3. Run tests ```php artisan dusk --env=testing```

## Licence

MIT
