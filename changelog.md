# Unreleased

## Changed

- Dependencies update
- `composer.lock` and `package-lock.json` are no longer under git

# 1.2.42

## Fixed

- Default locale on fresh install ([#75](https://github.com/MarceauKa/shaark/issues/75))

# 1.2.41

## Added

- Added dutch translation (thanks to [dododedodonl](https://github.com/dododedodonl), [#72](https://github.com/MarceauKa/shaark/pull/72))
- Ability to configure PDF size (thanks to [dododedodonl](https://github.com/dododedodonl), [#71](https://github.com/MarceauKa/shaark/pull/71))

## Changed

- Laravel 6.18

# 1.2.40

## Added

- Ability to add Custom CSS ([#67](https://github.com/MarceauKa/shaark/issues/67))

## Changed

- Laravel 6.17
- Fancy error pages

## Fixed

- PWA service worker location
- Update migration `UpdateLoginsAndDevicesTable` for compatibility with SQLite ([#68](https://github.com/MarceauKa/shaark/issues/68))
- Exports columns name are now translated

# 1.2.39

## Added

- Ability to add Custom JS ([#64](https://github.com/MarceauKa/shaark/issues/64))
- Shaark is now a Web Share Target (Work in progress, only on Android [#65](https://github.com/MarceauKa/shaark/issues/65))

## Fixed

- WebParser can now return null values ([#66](https://github.com/MarceauKa/shaark/issues/66))
- Missing french translations for pagination

## Removed

- Github actions

# 1.2.38

## Added

- Docker support ([documentation](https://github.com/MarceauKa/shaark/blob/dev/documentation/docker.md), [#63](https://github.com/MarceauKa/shaark/pull/63))

## Changed

- Cards are now displayed with masonry instead of stacked cards from Bootstrap
- HTTPS will be forced based on `APP_URL` instead of `APP_ENV`

## Fixed

- Posts count for a tag
- Disable unloading when a new post is submitted

# 1.2.37

## Added

- Forms will now prevent reloading or leaving the page if changes were made

## Changed

- Laravel 6.11
- Remove `Faker` from `require-dev` to use seeding in production
- Simplified pagination 

# 1.2.36

⚠️ Run migrations when updating

## Added

- Walls: customizable pages with tags and card type restrictions to provide the best way to browse your content

## Changed

- Laravel 6.9

## Fixed

- Content post not loaded in DatabaseSeeder

## Removed

- Appearance settings: Show chests on homepage, Show tags on homepage, Number of columns, Compact cards
- Removed `App\Post` model method `scopeOnlyLinks`

# 1.2.35

## Changed

- Laravel 6.6

## Fixed

- Security update fixing [https-proxy-agent](https://github.com/TooTallNate/node-https-proxy-agent)
- Security update fixing [serialize-javascript](https://github.com/yahoo/serialize-javascript) 

# 1.2.34

## Added

- CI build through Github action

## Changed

- Vue components for tests

## Fixed

- Add comment when global privacy is enabled
- LinkForm test
- Temp sharing for albums
- WebParser in test mode

# 1.2.33

⚠️ Run migrations when updating

## Added

- Comments on posts ([documentation](https://github.com/MarceauKa/shaark/blob/dev/documentation/comments.md), [#45](https://github.com/MarceauKa/shaark/issues/45))
- Captcha system
- Ability to choose prefered posts order: creation date or last update date ([#61](https://github.com/MarceauKa/shaark/issues/61))

## Changed

- New offline network monitor
- German and Japanese translations updated

## Fixed

- Typos on Story form
- Composer install and update commands

# 1.2.32

## Added

- Ability to rename tags
- In-app notification updater ([#31](https://github.com/MarceauKa/shaark/issues/31))
- PWA meta for iOS

## Changed

- Japanese translation updated to 1.2.31 (thanks to [wyred](https://github.com/wyred))

## Fixed

- Link, Story, Chest and Album default save action now reload the form
- Remove unused yarn.lock

# 1.2.31

## Added

- Search with history, loading indicator and no result indicator ([#59](https://github.com/MarceauKa/shaark/issues/59))
- Links now have a shortcut to archive.org ([#57](https://github.com/MarceauKa/shaark/issues/57))

## Fixed

- Story: Markdown editor on small devices ([#55](https://github.com/MarceauKa/shaark/issues/55))

## Changed

- New form actions "Save", "Save & New", "Save & View"
- Story is now displayed at full-width
- Cleaned some translations

## Removed

- Original shaarli import ([#30](https://github.com/MarceauKa/shaark/issues/30))

# 1.2.30

⚠️ Update your Git remote URL: `git remote set-url origin https://github.com/MarceauKa/shaark.git`

## Changed

- Laravel Shaarli is now Shaark ([#54](https://github.com/MarceauKa/shaark/issues/54))
- Japanese translation updated to 1.2.29 (thanks to [wyred](https://github.com/wyred))

# 1.2.29

## Added

- New search strategy using classic SQL search ([#33](https://github.com/MarceauKa/shaark/issues/33), [#52](https://github.com/MarceauKa/shaark/issues/52))
- Ability to choose search strategy in settings
- Chest content can be copied as a text ([#4](https://github.com/MarceauKa/shaark/issues/4))

## Fixed

- Text in modals not visible using dark mode ([#51](https://github.com/MarceauKa/shaark/issues/51))

# 1.2.28

## Added

- Albums can be downloaded as .zip
- Ability to test email configuration from settings
- Robots are disabled when global privacy is enabled

## Changed

- New responsive navbar ([#49](https://github.com/MarceauKa/shaark/issues/49))
- Limit displayed tags in tags card ([#50](https://github.com/MarceauKa/shaark/issues/50))
- Private archive setting is now Private download 
- CheckArchive is now CheckFeature

## Fixed

- Custom background UI

# 1.2.27

## Added

- Ability to customize image generation
- [Troubleshouting guide](https://github.com/MarceauKa/shaark/blob/dev/documentation/troubleshooting.md)

## Changed

- Laravel 6.5
- Japanese translation updated (thanks to [wyred](https://github.com/wyred))

## Fixed

- AlbumCard preview
- Missing translations on file uploader
- Markdown editor will now load correct language pack ([#42](https://github.com/MarceauKa/shaark/issues/42))
- Manage Tags and Manage Archives issues in responsive and dark mode ([#47](https://github.com/MarceauKa/shaark/issues/47))
- Keep old settings values when validation fails

# 1.2.26

## Added

- Add new Album content type for sharing your pictures
- Manage archives (in settings section)
- Ability to configure python path (for media archiving)
- Scheduled job to clean old or incomplete files from storage

## Changed

- No more URL hash for Archive downloading

## Fixed

- Fix composer issue after updating
- PasswordGenerator border radius

# 1.2.25

## Added

- Install button for PWA in settings

## Changed

- Laravel 6.4
- New theme (rounded, more icons, more space, new font)
- Replaced font "Rubik" by "IBM Plex Sans" (without Google Font)
- Move settings translation from frontend file to laravel file for performance issue

## Fixed

- PWA when global privacy is enabled 

# 1.2.24

## Added

- Progressive Web App compatibility ([#24](https://github.com/MarceauKa/shaark/issues/24))
- Default icon for Shaarli and ability to customize it
- Automatic [backup](https://github.com/MarceauKa/shaark/blob/dev/documentation/backup.md) ([#28](https://github.com/MarceauKa/shaark/issues/28))
- Network status monitor (for PWA)

## Changed

- Shaarli manager is now divised into multiple traits
- Move email translation from frontend file to laravel file for performance issue

# 1.2.23

## Added

- Japanese translation (thanks to [wyred](https://github.com/wyred))
- Ability to test PDF and Media archiving in settings ([#34](https://github.com/MarceauKa/shaark/issues/34))

## Changed

- Installation and archiving documentation
- Add `php artisan storage:link` to the update command
- Shaarli will now append default values to settings 

## Fixed

- Default locale setting

# 1.2.22

⚠️ If you have issues with settings, remove `custom_background` and `custom_background_encoded` from your `storage/settings.json`

## Added

- Ability to customize background as image or custom gradient ([#25](https://github.com/MarceauKa/shaark/issues/25), [#26](https://github.com/MarceauKa/shaark/issues/26))
- Shaarlies [listing](https://github.com/MarceauKa/shaark/blob/dev/directory.md)

## Changed

- Unused settings keys are now cleaned after settings update
- Shaarli default settings are now located in shaarli config file
- Move link preview and archive to LinkForm ([#29](https://github.com/MarceauKa/shaark/issues/29))
- Removed link preview action (previews are updated when saving a link)

## Fixed

- Translation in german updated (thanks to [kayschima](https://github.com/kayschima))
- Select tags now use `custom-select` class
- Move vue component styles to `app.scss`
- Modal component now correctly remove itself
- Wrong translation used when blocking in demo mode
- Typos in StoryForm

# 1.2.21

⚠️ Run migrations when updating

## Added

- RSS and Atom feeds ([#21](https://github.com/MarceauKa/shaark/issues/21))
- Pinned posts ([#11](https://github.com/MarceauKa/shaark/issues/11))

# 1.2.20

⚠️ Run migrations when updating

## Added

- Post content sharing ([#1](https://github.com/MarceauKa/shaark/issues/1))
- New Modal component

## Changed

- Password generator with more options
- Better JS dependencies extraction for lighter builds
- Tags icon on Search and tag page results
- copyToClipboard is now a mixin

## Fixed

- Create link then archive it ([#23](https://github.com/MarceauKa/shaark/issues/23))
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
