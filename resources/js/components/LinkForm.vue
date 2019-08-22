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
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" @click.prevent="submit" :disabled="loading">Enregistrer</button>
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
        link: Object|String,
    },

    data() {
        return {
            form: {
                url: null,
                title: null,
                content: null,
                is_private: false,
            },
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
