# 1.2.2

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
