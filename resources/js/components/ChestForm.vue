<template>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control" id="title" v-model="form.title" :disabled="loading">
            </div>

            <div class="form-group">
                <label>{{ __('Content') }}</label>
                <chest-lines v-model="form.content"></chest-lines>
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
            <a :href="chest.permalink" class="btn btn-outline-primary" v-if="chest">{{ __('View')}}</a>
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
                method: this.chest ? 'PUT' : 'POST',
                url: this.chest ? this.chest.url_update : '/api/chest',
                data: this.form
            }).then((response) => {
                if (this.chest) {
                    this.$toasted.success(this.__('Chest updated'));
                    this.loading = false;
                } else {
                    this.$toasted.success(this.__('Chest created'));
                    this.reset();
                }
            }).catch((error) => {
                this.loading = false;
                this.$toasted.error(this.__('Unable to save chest'));
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
