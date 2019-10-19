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
Vue.mixin(require('./i18n'));

import Toasted from 'vue-toasted';
Vue.use(Toasted, {
    position: 'top-center',
    duration: 5000,
});

import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect);

import Editor from '@toast-ui/vue-editor/src/Editor.vue';
Vue.component('editor', Editor);

import Viewer from '@toast-ui/vue-editor/src/Viewer.vue';
Vue.component('viewer', Viewer);

import { directive as onClickaway } from 'vue-clickaway';
Vue.directive('on-clickaway', onClickaway);

import draggable from 'vuedraggable';
Vue.component('draggable', draggable);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    el: '#app',
});
