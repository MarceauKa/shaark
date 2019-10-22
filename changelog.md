# 1.2.20

⚠️ Run migrations when updating

## Added

- Post content sharing (issue #1)
- New Modal component

## Changed

- Password generator with more options
- Better JS dependencies extraction for lighter builds
- Tags icon on Search and tag page results
- copyToClipboard is now a mixin

## Fixed

- Create link then archive it (issue #23)
- DatabaseSeeder for youtube link

# 1.2.19

## Added

- Shortcut to see Link, Story or Chest when created or updated
- Font Awesome 5 icons

## Fixed

- WebParser with empty result
- Dragging chest lines on Firefox

# 1.2.18

## Added

- Password generator for chests

## Changed

- WebParser now use Symfony DomCrawler
- DatabaseSeeder with english tags

## Fixed

- Responsive youtube preview

# 1.2.17

## Added

- Update command: `php artisan shaarli:update`

## Changed

- Refactored dark mode
- Title tag is read before open graph tags when parsing an URL

## Fixed

- Search global shortcut on Firefox
- Chest password are now readonly

# 1.2.16

## Added

- Check if a link has been already shared (thanks to [tuananhp-1844](https://github.com/tuananhp-1844))
- Tests for LinkForm

## Changed

- Only display available tags for the current user or guest
- Assets are now splitted into `vendor.js` and `app.js` to reduce bundle size

## Fixed

- Demo mode on manage tags and users API 

# 1.2.15

## Added

- Ability to hide card content (home and tag view)
- Ability to choose the number of columns displayed (home and tag view)
- Ability to display tags or not (home only)
- Ability to display chests or not (home only)

## Changed

- Laravel 6.2
- Removed `mavon-editor` and `vue-markdown` for `tui.editor`
- Card UI and Search UI

## Removed

- Alternative homepage

# 1.2.14

## Added

- Search can use operators such as: `-`, `and`, `or`, ...
- More tests !

## Fixed

- Search private content
- Postable `withPrivate` scope
- StoryFactory
- Migrations compatible with SQLite

# 1.2.13

⚠️ Run migrations when updating

## Added

- Multi-users
- Non-admin users can't access settings section

## Changed

- Manage section in separate controllers
- Logins history and logout other devices moved to account instead of manage
- Improvements on api http and form errors

## Fixed

- Pagination will now wrap

# 1.2.12

## Added

- Demo mode

# 1.2.11

## Added

- Ability to purge login history
- German translation (thanks to [kayschima](https://github.com/kayschima))
- Documentation for configuration, php and js dependencies
- Documentation for contribution

## Fixed

- Alternative homepage responsive

## Changed

- Moved `marceauka/laravel-scout-tntsearch-driver` to `teamtnt/laravel-scout-tntsearch-driver`

# 1.2.10

## Fixed

- SecureLogin will now work with remember
- Ability to logout other devices

## Added

- `current_password` validation rule

# 1.2.9

## Added

- `shaarli:chests:encrypt` and `shaarli:chests:decrypt` commands

## Changed

- Chests are now encrypted in database using AES-256-CBC
- Install command is now a class

## Fixed

- Settings will not merge shaarli config anymore
- Chest Export with non-encrypted values
- Typos in readme

# 1.2.8

## Changed

- Refactored link view to LinkCard, updated LinkForm
- Refactored chest view to ChestCard, updated ChestForm
- Refactored story view to StoryCard, updated StoryForm
- LinkActionsController to LinkArchiveController

# 1.2.7

## Added

- Move tagged posts to another tag
- Loader vue component

## Changed

- Refactored managing tags 

## Fixed

- Missing translations (custom background images)

# 1.2.6

## Fixed

- Default settings
- Custom background in dark mode

## Changed

- Screenshots

# 1.2.5

## Added

- Alternative homepage
- Ability to customize background image

## Changed

- Refactored settings (back and front)
- Card dropdown menu is not right aligned
- Assets are now versionned
- Screenshots in readme

# 1.2.4

## Changed

- LoginController throttles request
- AuthChecker now handles 2FA
- Secure login email notification CTA and message
- Assets are now versionned

## Fixed

- Secure Login don't log failed attempts
- Use `request()->input('code')` instead of `request('code')` in secure login form
- Story form confirm message i18n

# 1.2.3

⚠️ Run migrations when updating

## Added

- Log all logins and associated devices with new section in settings

## Fixed

- Typo in secure login page title
- Redirection when already logged

## Changed

- Composer definition
- Documentation about security

# 1.2.2

⚠️ Run migrations when updating

## Added

- 2-FA with email

## Changed

- Refactored Login

## Deleted

- Password resets, register and verify email logic
- `shaarli:self-update` command

# 1.2.1

## Added

- Assets are now staged preventing new compilation on each deployment

## Fixed

- Display newlines in links content
- Save button on LinkForm doesn't redirect to archiving

# 1.2.0

## Added

- Loader on LinkForm, StoryForm and ChestForm
- Add original URL to card-link
- Ability to "Save and archive" a link

## Changed

- Laravel 6.0
- Simplified Hashid
- Chests can now be searched from their non-sensitive content

## Deleted

- Feeds 

# 1.1.1

## Fixed

- Deleting a link will also delete its archive
- Prevent link archive download when "private archive" option is set to true

# 1.1.0

## Added

- Link can now be archived using Puppeteer or Youtube-dl
- Queue configuration

## Changed

- Link extra is now link preview

## Fixed

- Default settings now use the correct locale

# 1.0.0

- Initial release
