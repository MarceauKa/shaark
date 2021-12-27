<template>
    <div>
        <div class="row" v-if="enabled">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Links watched') }}</small>
                        <h3 class="text-right text-capitalize">{{ stats.total }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Links not watched') }}</small>
                        <h3 class="text-right text-capitalize">{{ stats.disabled }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Live (2xx)') }}</small>
                        <h3 class="text-right text-capitalize" :class="{'text-success': stats.live > 0}">
                            {{ stats.live }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Redirect (3xx)') }}</small>
                        <h3 class="text-right text-capitalize">{{ stats.redirect }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Dead (4xx)') }}</small>
                        <h3 class="text-right text-capitalize" :class="{'text-danger': stats.dead > 0}">
                            {{ stats.dead }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Error (5xx)') }}</small>
                        <h3 class="text-right text-capitalize" :class="{'text-danger': stats.error > 0}">
                            {{ stats.error }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-heartbeat mr-1"></i>
                {{ __('Links health') }}
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0" v-if="!enabled">
                    {{ __('Health checks for links are disabled') }}
                </div>

                <div v-else>
                    <div v-for="type in types">
                        <div class="card-title">{{ type.name }}</div>

                        <div class="alert alert-info" v-if="type.loading">
                            {{ __('Loading') }}
                        </div>

                        <div class="alert alert-success" v-if="stats[type.type] === 0">
                            {{ __('No problem found') }}
                        </div>

                        <div class="table-responsive" v-else>
                            <table class="table table-borderless table-sm">
                                <thead>
                                <tr>
                                    <th>{{ __('Link') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Last checked') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="link in links[type.type]">
                                    <td class="align-middle">
                                        <a :href="link.permalink">
                                            {{ link.title.substr(0, 40) }}
                                            <span v-if="link.title.lenght >= 40">...</span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ link.http_status }}
                                    </td>
                                    <td>
                                        {{ link.http_checked_at_formated }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        enabled: {
            type: Boolean,
            required: true,
        },
        stats: {
            type: Object,
            required: false,
            default: () => {},
        },
    },

    data () {
        return {
            types: [{
                type: 'dead',
                name: this.__('Dead (4xx)'),
                loading: false,
            }, {
                type: 'error',
                name: this.__('Error (5xx)'),
                loading: false,
            }, {
                type: 'redirect',
                name: this.__('Redirect (3xx)'),
                loading: false,
            }],
            links: {
                dead: [],
                error: [],
                redirect: [],
            },
        }
    },

    mounted () {
        this.types.forEach((type) => {
            this.fetch(type)
        })
    },

    methods: {
        fetch (type) {
            let count = this.stats[type.type] || 0

            if (count === 0) {
                return
            }

            type.loading = true

            axios.get(`/api/manage/links-health/${type.type}`).then(response => {
                this.links[type.type] = response.data.data
                type.loading = false
            }).catch(error => {
                type.loading = false
            })
        },
    },
}
</script>
