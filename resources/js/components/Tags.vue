<template>
    <multiselect :value="$attrs.value"
                 :tag-placeholder="__('Create tag')"
                 :selectLabel="__('Click to select')"
                 :deselectLabel="__('Click to select')"
                 :noOptions="__('No tag')"
                 :placeholder="__('Search or type a tag')"
                 open-direction="bottom"
                 :options="options"
                 :multiple="true"
                 :taggable="true"
                 :loading="loading"
                 :closeOnSelect="false"
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
                this.$toasted.error(this.__("Can't fetch tags"));
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

<style lang="scss">
    .multiselect__tags {
        border-color: #ced4da;
        border-radius: 0;

        .multiselect__tag {
            margin-bottom: 0;
        }
    }
</style>
