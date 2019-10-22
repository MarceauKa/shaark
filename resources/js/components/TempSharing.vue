<template>
    <modal :open="open" size="lg" @closed="open = false">
        <template #header>{{ __('Temp sharing of :title', {title: post.title}) }}</template>
        <template #content>
            <h4>{{ __('Create link') }}</h4>

            <p>{{ __("Content will be accessible even private until expiration.") }}</p>

            <div class="form-group">
                <label for="expiration">{{ __('Link expires in') }}</label>
                <select name="expiration" id="expiration" class="form-control custom-select" v-model="form.expiration">
                    <option v-for="expiration in expirations" :value="expiration.key">{{ __(expiration.name) }}</option>
                </select>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-outline-primary" @click="generate" :disabled="loading">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    {{ __('Generate') }}
                </button>
            </div>

            <h4>{{ __('Active links') }}</h4>

            <table class="table table-borderless table-sm" v-if="shares.length > 0">
                <thead>
                <tr>
                    <th class="w-75">{{ __('URL') }}</th>
                    <th class="w-25">{{ __('Expiration') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="share in shares">
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" :value="share.url">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" @click="copyToClipboard($event, share.url)">{{ __('Copy') }}</button>
                            </div>
                        </div>
                    </td>
                    <td>{{ share.expires_at }}</td>
                </tr>
                </tbody>
            </table>

            <div class="alert alert-info" v-else>{{ __('This content is not actually shared') }}</div>
        </template>
    </modal>
</template>

<script>
import httpErrors from '../mixins/httpErrors';
import copyToClipboard from '../mixins/copyToClipboard';

export default {
    mixins: [
        copyToClipboard,
        httpErrors,
    ],

    data() {
        return {
            loading: false,
            open: false,
            post: null,
            shares: [],
            form: {
                expiration: 'hour',
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
            axios.get(this.post.url_share)
                .then((response) => {
                    this.shares = response.data.shares;
                })
                .catch((error) => {
                    this.setHttpError(error);
                    this.toastHttpError(this.__("Can't fetch shares"));
                });
        },

        generate() {
            this.loading = true;

            axios.post(this.post.url_share, {
                expiration: this.form.expiration
            })
                .then((response) => {
                    this.loading = false;
                    this.shares.unshift(response.data.share);
                    this.$toasted.success(this.__("Link generated"));
                })
                .catch((error) => {
                    this.loading = false;
                    this.setHttpError(error);
                    this.toastHttpError(this.__("Unable to create link for this content"));
                });
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
