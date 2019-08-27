<template>
    <form class="form-inline">
        <input class="form-control w-100" type="search" ref="input"
               placeholder="Tapez / pour chercher" v-model="query">

        <div class="list-group results" :class="{'active': hasResults}" v-on-clickaway="hide">
            <li class="list-group-item" v-if="hasTagsResults">
                Tags :
                <a v-for="result in results.tags" class="btn btn-primary btn-sm" v-if="hasTagsResults" :href="result.url">
                    {{ result.name }}
                </a>
            </li>

            <a v-for="result in results.posts" v-if="hasPostsResults"
               :href="result.url" class="list-group-item list-group-item-action">
                <div>
                    <span>{{ result.type }}</span> &mdash;
                    <strong>{{ result.title }}</strong>
                </div>
                <div v-if="result.tags.length > 0">
                    <span class="badge badge-secondary" v-for="tag in result.tags">{{ tag }}</span>
                </div>
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
            let isEventSafe = (event) => {
                return event.target.tagName != 'INPUT'
                    && event.target.tagName != 'TEXTAREA';
            };

            if (event.keyCode === 191 && isEventSafe(event)) {
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
                || this.hasPostsResults
        },

        hasTagsResults() {
            return this.results.hasOwnProperty('tags')
                && this.results.tags.length > 0;
        },

        hasPostsResults() {
            return this.results.hasOwnProperty('posts')
                && this.results.posts.length > 0;
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
        .list-group-item {
            display: flex;
            justify-content: space-between;
            div:first-child {
                > span {
                    text-transform: uppercase;
                }
            }
        }
    }
</style>
