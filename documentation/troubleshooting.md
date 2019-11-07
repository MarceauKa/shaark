# Shaarli - Troubleshooting

## Install and update

At first, read our [installation guide](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/installation.md).

### Can't access the app once installed

Make sure the document root of your host points to the `/public` folder.

### Error when updating with the `shaarli:update` command

Sometimes you can have issues when upgrading, running the command a second time will generaly solve the problem.

### Error with routing or views

Run these commands to get rid of common errors:
- `php artisan optimize`
- `php artisan view:clear`

### JS or CSS is broken

Please check:
- Browser cache
- Git branch must be on `master`
- App URL must be configured in your `.env`

## Images

### Thumbnails are not correctly generated

Use the following command to regenerate images: `php artisan media:regenerate`

## Archiving

Read our [archiving guide](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md).

## Backup

Read our [backup guide](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/backup.md).

## Dependencies

See [dependencies](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/dependencies.md) used in this application.


