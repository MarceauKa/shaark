<template>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" class="form-control" id="url" v-model="form.url" :disabled="loading">
                <small class="form-text text-muted" v-if="parsing">Récupération des informations...</small>
            </div>

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" class="form-control" id="title" v-model="form.title" :disabled="loading">
            </div>

            <div class="form-group">
                <label for="content">Contenu</label>
                <textarea id="content" class="form-control" v-model="form.content" :disabled="loading"></textarea>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_private" v-model="form.is_private" :disabled="loading">
                    <label class="custom-control-label" for="is_private">Lien privé ?</label>
                </div>
            </div>

            <div class="form-group">
                <multiselect v-model="form.tags"
                             tag-placeholder="Créer le tag"
                             selectLabel="Cliquez pour sélectionner"
                             deselectLabel="Cliquez pour désectionner"
                             noOptions="Aucun tag"
                             placeholder="Cherchez ou tapez un tag"
                             :options="tags"
                             :multiple="true"
                             :taggable="true"
                             @tag="newTag"
                ></multiselect>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" @click.prevent="submit" :disabled="loading">Enregistrer</button>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';

let defaultLink = function () {
    return {
        url: null,
        title: null,
        content: null,
        is_private: false,
        tags: [],
    };
};

export default {
    components: {
        'multiselect': Multiselect,
    },

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
        tags: {
            type: Array,
            required: false,
            default: [],
        },
        link: Object|String,
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

        submit() {
            this.loading = true;

            axios.request({
                method: this.method,
                url: this.submitUrl,
                data: this.form
            }).then((response) => {
                this.reset();
                this.$toasted.success("Lien ajouté !");
            }).catch((error) => {
                this.loading = false;
                this.$toasted.error("Impossible d'ajouter le lien.");
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
        }
    },

    watch: {
        'form.url': _.debounce(function (value) {
            if (value) {
                this.parse(value)
            }
        }, 500),
    }
}
</script>
