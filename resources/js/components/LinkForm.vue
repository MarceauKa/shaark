<template>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="url">{{ __('URL') }}</label>
                <input type="text" class="form-control" ref="url" id="url" v-model="form.url">
                <small class="form-text text-muted" v-if="parsing">{{ __('Retrieving URL informations...') }}</small>
            </div>

            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control" id="title" v-model="form.title" :disabled="loading">
            </div>

            <div class="form-group">
                <label for="content">{{ __('Content') }}</label>
                <textarea id="content" class="form-control" v-model="form.content" :disabled="loading"></textarea>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_private" v-model="form.is_private" :disabled="loading">
                    <label class="custom-control-label" for="is_private">{{ __('Private link?') }}</label>
                </div>
            </div>

            <div class="form-group">
                <label>{{ __('Tags') }}</label>
                <tags v-model="form.tags"></tags>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <div>
                <button class="btn btn-primary" @click.prevent="submit" :disabled="loading">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    {{ __('Save') }}
                </button>
                <button class="btn btn-outline-primary" @click.prevent="submit(true)" :disabled="loading">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    {{ __('Save then archive') }}
                </button>
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

export default {
    props: {
        parseUrl: {
            type: String,
            required: true
        },
        submitUrl: {
            type: String,
            required: true
        },
        queryUrl: {
            type: String,
            required: false
        },
        method: {
            type: String,
            required: false,
            default: 'POST'
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

            axios.post(this.parseUrl, {
                url: this.form.url
            }).then((response) => {
                this.loading = false;
                this.parsing = false;

                if (response.status === 200) {
                    this.form.title = response.data.title;
                    this.form.content = response.data.content;
                }
            }).catch((error) => {
                this.loading = false;
                this.parsing = false;
                console.log(error);
            });
        },

        submit(redirectToArchive = false) {
            this.loading = true;

            axios.request({
                method: this.method,
                url: this.submitUrl,
                data: this.form
            }).then((response) => {
                if (this.link) {
                    this.$toasted.success(this.__('Link updated'));
                    this.loading = false;
                } else {
                    this.$toasted.success(this.__('Link created'));
                    this.reset();
                }

                if (redirectToArchive === true) {
                    window.location = `/link/archive/${response.data.id}`;
                }
            }).catch((error) => {
                this.loading = false;
                this.$toasted.error(this.__('Unable to save link'));
                console.log(error);
            })
        },

        reset() {
            this.loading = false;
            this.parsing = false;
            this.form = defaultLink();
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
