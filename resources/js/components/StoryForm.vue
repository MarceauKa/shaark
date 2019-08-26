<template>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" class="form-control" id="title" v-model="form.title" :disabled="loading">
                <p class="text-muted"><small>{{ fullUrl }}</small></p>
            </div>

            <div class="form-group">
                <label for="content">Contenu</label>
                <mavon-editor id="content"
                              language="fr"
                              :boxShadow="false"
                              :toolbars="editorToolbars"
                              v-model="form.content"></mavon-editor>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_private" v-model="form.is_private" :disabled="loading">
                    <label class="custom-control-label" for="is_private">Story privée ?</label>
                </div>
            </div>

            <div class="form-group">
                <tags v-model="form.tags"></tags>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" @click.prevent="submit" :disabled="loading">Enregistrer</button>
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

import Editor from 'mavon-editor';
Vue.use(Editor);

export default {
    components: {
        Editor
    },

    props: {
        submitUrl: {
            type: String,
            required: true
        },
        method: {
            type: String,
            required: false,
            default: 'POST'
        },
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
            editorToolbars: {
                bold: true,
                italic: true,
                header: true,
                underline: true,
                strikethrough: true,
                mark: true,
                superscript: true,
                subscript: true,
                quote: true,
                ol: true,
                ul: true,
                link: true,
                imagelink: true,
                code: true,
                table: true,
                fullscreen: false,
                readmodel: false,
                htmlcode: false,
                help: false,
                undo: true,
                redo: true,
                trash: false,
                save: false,
                navigation: false,
                alignleft: true,
                aligncenter: true,
                alignright: true,
                subfield: true,
                preview: true
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
                method: this.method,
                url: this.submitUrl,
                data: this.form
            }).then((response) => {
                if (this.story) {
                    this.$toasted.success("Story modifiée !");
                    this.loading = false;
                } else {
                    this.$toasted.success("Story ajoutée !");
                    this.reset();
                }
            }).catch((error) => {
                this.loading = false;
                this.$toasted.error("Impossible d'enregistrer la story.");
                console.log(error);
            })
        },

        reset() {
            this.loading = false;
            this.form = defaultStory();
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
