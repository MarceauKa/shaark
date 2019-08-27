<template>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" class="form-control" id="title" v-model="form.title" :disabled="loading">
            </div>

            <div class="form-group">
                <label>Contenu</label>
                <chest-lines v-model="form.content"></chest-lines>
            </div>

            <div class="form-group">
                <label>Tags</label>
                <tags v-model="form.tags"></tags>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" @click.prevent="submit" :disabled="loading">Enregistrer</button>
        </div>
    </div>
</template>

<script>
let defaultChest = function () {
    return {
        title: '',
        content: [],
        tags: [],
    };
};

export default {
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
        chest: {
            type: Object,
            required: false,
            default: () => {}
        },
    },

    data() {
        return {
            form: defaultChest(),
            loading: false
        }
    },

    mounted() {
        if (this.chest) {
            this.form = this.chest;
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
                if (this.chest) {
                    this.$toasted.success("Coffre modifié !");
                    this.loading = false;
                } else {
                    this.$toasted.success("Coffre ajouté !");
                    this.reset();
                }
            }).catch((error) => {
                this.loading = false;
                this.$toasted.error("Impossible d'enregistrer le coffre.");
                console.log(error);
            })
        },

        reset() {
            this.loading = false;
            this.form = defaultChest();
        },
    }
}
</script>
