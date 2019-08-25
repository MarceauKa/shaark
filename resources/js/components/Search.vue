<template>
    <form class="form-inline">
        <input class="form-control w-100" type="search" ref="input"
               placeholder="Tapez / pour chercher" v-model="query">

        <div class="list-group results" :class="{'active': hasResults}" v-on-clickaway="hide">
            <li class="list-group-item" v-if="hasTagsResults">
                Tags :
                <a v-for="result in results.tags" class="btn btn-primary btn-sm" v-if="hasTagsResults" :href="result.url">
                    {{ result.name }} <span class="badge badge-light">{{ result.count }}</span>
                </a>
            </li>

            <a v-for="result in results.links" v-if="hasLinksResults"
               :href="result.url" class="list-group-item list-group-item-action">
                <p class="mb-0"><strong>{{ result.title }}</strong></p>
                <p class="mb-0">{{ result.content }}</p>
                <p class="mb-0 text-right" v-if="result.tags.length > 0">
                    <span class="badge badge-secondary" v-for="tag in result.tags">{{ tag }}</span>
                </p>
            </a>
        </div>
    </form>
</template>

<script>
import { directive as onClickaway } from 'vue-clickaway';

export default {
    directives: {
        onClickaway: onClickaway,
    },

    props: {
        url: {
            type: String,
            required: true
        },
    },

    data() {
        return {
            query: null,
            results: {},
            loading: false,
        }
    },

    mounted() {
        document.addEventListener('keydown', (event) => {
            if (event.keyCode === 191) {
                event.preventDefault();
                event.stopPropagation();
                this.$refs.input.focus();
            }
        })
    },

    methods: {
        search() {
            this.loading = true;

            axios.post(this.url, {
                query: this.query
            }).then((response) => {
                this.loading = false;

                if (response.status === 200) {
                    this.results = response.data;
                }
            }).catch((error) => {
                this.loading = false;
                console.log(error);
            });
        },

        hide() {
            this.query = "";
            this.results = {};
        }
    },

    computed: {
        hasResults() {
            return this.hasTagsResults
                || this.hasLinksResults
        },

        hasTagsResults() {
            return this.results.hasOwnProperty('tags')
                && this.results.tags.length > 0;
        },

        hasLinksResults() {
            return this.results.hasOwnProperty('links')
                && this.results.links.length > 0;
        }
    },

    watch: {
        query: _.debounce(function (value) {
            if (value && value.length >= 3) {
                this.search(value)
            }
        }, 200),
    }
}
</script>

<style lang="scss">
    .form-inline {
        position: relative;
        margin-bottom: 0;
    }
    .results {
        z-index: 500;
        position: absolute;
        top: 40px;
        width: calc(100% - 2rem);
        display: none;
        &.active {
            display: block;
        }
    }
    .multiselect__tags,
    .multiselect__content-wrapper {
        border-radius: 0;
        border-color: #ced4da;
    }
</style>
