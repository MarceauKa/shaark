<template>
    <modal :open="open" size="lg" @closed="open = false">
        <template #header>{{ __('Temp sharing of :title', {title: post.title}) }}</template>
        <template #content>
            <h4>{{ __('Create link') }}</h4>

            <p>{{ __("Content will be accessible even private until expiration.") }}</p>

            <div class="form-group row">
                <label for="expiration" class="col-md-3 col-form-label">{{ __('Share expires in') }}</label>

                <div class="col-md-9">
                    <select name="expiration" id="expiration" class="form-control" v-model="form.expiration">
                        <option :value="null">{{ __('Select an expiration') }}</option>
                        <option v-for="expiration in expirations" :value="expiration.key">{{ __(expiration.name) }}</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-9 offset-md-3">
                    <button type="button" class="btn btn-primary">{{ __('Generate') }}</button>
                </div>
            </div>

            <h4>{{ __('Active links') }}</h4>

            <table class="table table-sm" v-if="shares.length > 0">
                <thead>
                <tr>
                    <th>{{ __('Link') }}</th>
                    <th>{{ __('Expiration') }}</th>
                </tr>
                </thead>
            </table>

            <div class="alert alert-info" v-else>{{ __('This content is not actually shared') }}</div>
        </template>
    </modal>
</template>

<script>
export default {
    data() {
        return {
            open: false,
            post: null,
            shares: [],
            form: {
                expiration: null,
            },
            expirations: [
                {key: 'hour', name: '1 hour'},
                {key: 'hours', name: '12 hours'},
                {key: 'day', name: '1 day'},
                {key: 'days', name: '3 days'},
                {key: 'week', name: '1 week'},
                {key: 'weeks', name: '2 weeks'},
                {key: 'month', name: '1 month'},
            ]
        }
    },

    mounted() {
        this.$bus.$on('share', (post) => {
            this.post = post;
            this.open = true;
            this.get();
        })
    },

    methods: {
        get() {
            axios.get(this.post.url_share).then((response) => {
                this.shares = response.data.shares;
            }).catch((error) => {
                this.$toasted.error(this.__("Can't fetch shares"));
            })
        },

        store() {

        },
    },

    watch: {
        open: function (value) {
            if (value === false) {
                this.post = null;
                this.shares = [];
            }
        }
    }
}
</script>
