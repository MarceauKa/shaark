<template>
    <div class="card card--story">
        <div class="card-body">
            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control" :class="{'is-invalid': hasFormError('title')}" id="title" v-model="form.title" :disabled="loading">
                <span class="invalid-feedback" v-if="hasFormError('title')">{{ firstFormError('title') }}</span>
                <p class="text-muted"><small>{{ fullUrl }}</small></p>
            </div>

            <div class="form-group">
                <label for="content">{{ __('Content') }}</label>
                <editor id="content"
                        previewStyle="vertical"
                        :options="editor"
                        v-model="form.content"
                ></editor>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_private" v-model="form.is_private" :disabled="loading">
                    <label class="custom-control-label" for="is_private">{{ __('Private story?') }}</label>
                </div>
            </div>

            <div class="form-group">
                <label>{{ __('Tags') }}</label>
                <tags v-model="form.tags"></tags>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" @click.prevent="submit" :disabled="loading">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                {{ __('Save') }}
            </button>
            <a :href="story.url" class="btn btn-outline-primary" v-if="story">{{ __('View')}}</a>
        </div>
    </div>
</template>

<script>
let defaultStory = function () {
    return {
        title: '',
        slug: '',
        content: '',
        is_private: false,
        tags: [],
    };
};

import formErrors from "../mixins/formErrors";
import httpErrors from "../mixins/httpErrors";
import 'tui-editor/dist/tui-editor.css';
import 'codemirror/lib/codemirror.css';
import Editor from '@toast-ui/vue-editor/src/Editor.vue'

export default {
    mixins: [
        formErrors,
        httpErrors,
    ],

    components: {
        Editor
    },

    props: {
        story: {
            type: Object,
            required: false,
            default: () => {}
        },
    },

    data() {
        return {
            form: defaultStory(),
            loading: false,
            editor: {
                minHeight: '300px',
                language: 'fr_FR',
                useCommandShortcut: true,
                useDefaultHTMLSanitizer: true,
                usageStatistics: false,
                hideModeSwitch: true,
                toolbarItems: [
                    'heading',
                    'bold',
                    'italic',
                    'strike',
                    'divider',
                    'hr',
                    'quote',
                    'divider',
                    'ul',
                    'ol',
                    'task',
                    'indent',
                    'outdent',
                    'divider',
                    'table',
                    'image',
                    'link',
                    'divider',
                    'code',
                    'codeblock'
                ]
            }
        }
    },

    mounted() {
        if (this.story) {
            this.form = this.story;
        }
    },

    methods: {
        submit() {
            this.loading = true;

            axios.request({
                method: this.story ? 'PUT' : 'POST',
                url: this.story ? this.story.url_update : '/api/story',
                data: this.form
            }).then(response => {
                if (this.story) {
                    this.$toasted.success(this.__("Story updated"), {
                        action: {text: this.__('Show'), href: response.data.post.url}
                    });
                    this.loading = false;
                } else {
                    this.$toasted.success(this.__("Story created"), {
                        action: {text: this.__('Show'), href: response.data.post.url}
                    });
                    this.reset();
                }
            }).catch(error => {
                this.loading = false;
                this.setFormError(error);
                this.setHttpError(error);
                this.toastHttpError(this.__("Unable to save story"));
            })
        },

        reset() {
            this.loading = false;
            this.form = defaultStory();
            this.resetFormError();
        },
    },

    computed: {
        fullUrl: function() {
            return `${window.location.origin}/${this.form.slug}`;
        },
    },

    watch: {
        'form.title': function(value) {
            this.form.slug = value.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        },
    }
}
</script>
