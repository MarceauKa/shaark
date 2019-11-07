const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .extract([
        'axios',
        'bootstrap',
        'codemirror',
        'highlight.js',
        'jquery',
        'lodash',
        'mdurl',
        'popper.js',
        'sortablejs',
        'to-mark',
        'tui-code-snippet',
        'tui-editor',
        'vue-filepond',
        'vue',
        'v-img',
        'vue-clickaway',
        'vue-masonry-css',
        'vue-multiselect',
        'vue-toasted',
        'vuedraggable',
    ])
    .sass('resources/sass/app.scss', 'public/css')
    .version();
