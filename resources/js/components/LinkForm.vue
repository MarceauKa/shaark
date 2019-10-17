<template>
    <div class="card card--link">
        <div class="card-body">
            <div class="form-group">
                <label for="url">{{ __('URL') }}</label>
                <input type="text" class="form-control" :class="{'is-invalid': hasFormError('url')}" ref="url" id="url" v-model="form.url" dusk="link-form-url">
                <span class="invalid-feedback" v-if="hasFormError('url')">{{ firstFormError('url') }}</span>
                <small class="form-text text-muted" v-if="parsing" dusk="link-form-parsing-message">{{ __('Retrieving URL informations...') }}</small>
            </div>

            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control" :class="{'is-invalid': hasFormError('title')}" id="title" v-model="form.title" :disabled="loading" dusk="link-form-title">
                <span class="invalid-feedback" v-if="hasFormError('title')">{{ firstFormError('title') }}</span>
            </div>

            <div class="form-group">
                <label for="content">{{ __('Content') }}</label>
                <textarea id="content" class="form-control" :class="{'is-invalid': hasFormError('content')}" v-model="form.content" :disabled="loading" dusk="link-form-content"></textarea>
                <span class="invalid-feedback" v-if="hasFormError('content')">{{ firstFormError('content') }}</span>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_private" v-model="form.is_private" :disabled="loading">
                    <label class="custom-control-label" for="is_private" dusk="link-form-private">{{ __('Private link?') }}</label>
                </div>
            </div>

            <div class="form-group">
                <label>{{ __('Tags') }}</label>
                <tags v-model="form.tags" dusk="link-form-tags"></tags>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <div>
                <button class="btn btn-primary" @click.prevent="submit" :disabled="loading" dusk="link-form-save">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    {{ __('Save') }}
                </button>
                <button class="btn btn-outline-primary" @click.prevent="submit(true)" :disabled="loading">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    {{ __('Save then archive') }}
                </button>
                <a :href="link.permalink" class="btn btn-outline-primary" v-if="link">{{ __('View')}}</a>
            </div>

            <slot name="actions"></slot>
        </div>
    </div>
</template>

<script>
let defaultLink = function () {
    return {
        url: null,
        title: null,
        content: null,
        is_private: false,
        tags: []
    };
};

import formErrors from "../mixins/formErrors";
import httpErrors from "../mixins/httpErrors";

export default {
    mixins: [
        formErrors,
        httpErrors,
    ],

    props: {
        queryUrl: {
            type: String,
            required: false
        },
        link: {
            type: Object,
            required: false,
            default: () => {}
        }
    },

    data() {
        return {
            form: defaultLink(),
            parsing: false,
            loading: false,
        }
    },

    mounted() {
        if (this.queryUrl) {
            this.form.url = this.queryUrl;
        }

        if (this.link) {
            this.form = this.link;
        }
    },

    methods: {
        parse() {
            this.loading = true;
            this.parsing = true;

            axios.post('/api/link/parse', {
                url: this.form.url
            }).then(response => {
                this.loading = false;
                this.parsing = false;

                if (response.status === 200) {
                    this.form.title = response.data.title;
                    this.form.content = response.data.content;
                }
            }).catch(error => {
                this.loading = false;
                this.parsing = false;

                this.setFormError(error);
                this.setHttpError(error);
                this.toastHttpError(this.__("Unable to parse link"));
            });
        },

        submit(redirectToArchive = false) {
            this.loading = true;

            axios.request({
                method: this.link ? 'PUT' : 'POST',
                url: this.link ? this.link.url_update : '/api/link',
                data: this.form
            }).then(response => {
                if (this.link) {
                    this.$toasted.success(this.__('Link updated'), {
                        action: {text: this.__('Show'), href: response.data.post.url}
                    });
                    this.loading = false;
                } else {
                    this.$toasted.success(this.__('Link created'), {
                        action: {text: this.__('Show'), href: response.data.post.url}
                    });
                    this.reset();
                }

                if (redirectToArchive === true) {
                    window.location = `/link/archive/${response.data.id}`;
                }
            }).catch(error => {
                this.loading = false;
                this.setFormError(error);
                this.setHttpError(error);
                this.toastHttpError(this.__('Unable to save link'));
            })
        },

        reset() {
            this.loading = false;
            this.parsing = false;
            this.form = defaultLink();
            this.resetFormError();
        },

        newTag(value) {
            this.tags.push(value);
            this.form.tags.push(value);
        }
    },

    watch: {
        'form.url': _.debounce(function (value) {
            if (value && ! this.link) {
                this.parse(value)
            }
        }, 500),
    }
}
</script>
