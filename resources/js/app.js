window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

let apiToken = document.head.querySelector('meta[name="api-token"]');
if (apiToken) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + apiToken.content;
}

window.Vue = require('vue');

import VueMarkdown from 'vue-markdown'
Vue.component('vue-markdown', VueMarkdown);

import Toasted from 'vue-toasted';
Vue.use(Toasted, {
    position: 'top-center',
});

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    el: '#app',
});
