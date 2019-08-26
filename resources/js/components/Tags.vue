<template>
    <multiselect :value="$attrs.value"
                 tag-placeholder="Créer le tag"
                 selectLabel="Cliquez pour sélectionner"
                 deselectLabel="Cliquez pour désectionner"
                 noOptions="Aucun tag"
                 placeholder="Cherchez ou tapez un tag"
                 open-direction="bottom"
                 :options="options"
                 :multiple="true"
                 :taggable="true"
                 :loading="loading"
                 @tag="create"
                 @select="select"
                 @remove="deselect"
    ></multiselect>
</template>

<script>
import Multiselect from 'vue-multiselect';

export default {
    components: {
        'multiselect': Multiselect,
    },

    data() {
        return {
            options: [],
            loading: false,
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get('/api/tags').then((response) => {
                this.loading = false;
                this.options = response.data;
            }).catch((error) => {
                this.loading = false;
                this.$toasted.error("Impossible de récupérer les tags.");
                console.log(error);
            })
        },

        select(event) {
            this.$attrs.value.push(event);
            this.$emit('input', this.$attrs.value)
        },

        deselect(event) {
            this.$attrs.value.splice(this.$attrs.value.indexOf(event), 1);
            this.$emit('input', this.$attrs.value)
        },

        create(value) {
            this.options.push(value);
            this.$attrs.value.push(value);
        },
    }
}
</script>
