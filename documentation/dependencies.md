# Shaarli - Dependencies

Our dependencies with link to their documentation and why we use it.

### PHP

- [laravel-auth-checker](https://github.com/404labfr/laravel-auth-checker) is used to keep a trace of auth attempts
- [scout](https://laravel.com/docs/6.x/scout) is used for full-text search in database
- [excel](https://github.com/Maatwebsite/Laravel-Excel) is used to generate exports as xlsx or csv
- [valuestore](https://github.com/spatie/valuestore) is used for application settings
- [dom-crawler](https://github.com/symfony/dom-crawler) is used to read metadata from posted links
- [puphpeteer](https://github.com/nesk/puphpeteer/) is used to [save your links as PDF](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md) using a chrome browser
- [youtube-dl-php](https://github.com/norkunas/youtube-dl-php) is a bridge to youtube-dl to [save your links](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/archiving.md) (youtube, soundcloud, ...) as a local copy
- [laravel-media-library](https://github.com/spatie/laravel-medialibrary) is used to attach images to models and image manipulation
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
- [vue-filepond](https://github.com/pqina/vue-filepond) is used to handle file upload
- [vue-masonry-css](https://github.com/paulcollett/vue-masonry-css) is used to display album images
