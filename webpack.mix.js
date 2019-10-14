const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .extract([
        'axios',
        'bootstrap',
        'jquery',
        'lodash',
        'popper.js',
        'vue',
    ])
    .sass('resources/sass/app.scss', 'public/css')
    .version();
