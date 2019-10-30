# Shaarli - Backup

## Getting started

⚠️ Make sure you have configured a CRON job.

`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`

## Configuration

Open your `.env` file and configure `BACKUP_*` lines.

Available driver are `local` and `ftp`. If you choose `local` you're done with the configuration.  
All others lines are for the `ftp` driver.

## Settings

In the settings section of the app, go to the **Backup** panel. You can:

- Enable or disable automatic backup.
- Choose to backup **daily** or **weekly**.
- Choose to save only the database. Saving files can consume a lot of disk space, especially if you use [archiving](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md).

## Commands

- Run backup manually: `php artisan backup:run`
- Run backup manually (only db): `php artisan backup:run --only-db`
- List all backups: `php artisan backup:list`
- Clean old backups: `php artisan backup:clean`
