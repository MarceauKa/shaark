<template>
    <form class="form-inline position-relative mb-0">
        <input class="form-control w-100"
               type="search"
               ref="input"
               :placeholder="__('Type / to search')"
               v-model="query"
               @keydown.down.stop="move('down')"
               @keydown.up.stop="move('up')"
               @keydown.enter.prevent.stop="redirect"
        >

        <div class="list-group results mt-1"
             :class="{'active': hasResults}"
             v-on-clickaway="hide"
        >
            <div class="list-group-item"
                v-if="hasTagsResults"
            >
                <div><i class="fas fa-tags"></i> {{ __('Tags') }}</div>
                <div>
                    <a v-for="result in results.tags"
                       class="btn btn-primary btn-sm mr-1"
                       v-if="hasTagsResults"
                       :href="result.url"
                    >
                        {{ result.name }}
                    </a>
                </div>
            </div>

            <a v-for="(result, key) in results.posts"
               v-if="hasPostsResults"
               :href="result.url"
               class="list-group-item list-group-item-action"
               :class="{'active': selected === result}"
            >
                <div>
                    <span>{{ result.type }} &mdash;</span>
                    <strong>{{ result.title }}</strong>
                </div>

                <div v-if="result.tags.length > 0">
                    <span class="badge badge-secondary mr-1" v-for="tag in result.tags">{{ tag }}</span>
                </div>
            </a>
        </div>
    </form>
</template>

<script>
export default {
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
            selected: null,
        }
    },

    mounted() {
        document.addEventListener('keydown', (event) => {
            let isEventSafe = (event) => {
                return event.target.tagName !== 'INPUT'
                    && event.target.tagName !== 'TEXTAREA';
            };

            if (['/'].indexOf(event.key) !== -1 && isEventSafe(event)) {
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
                    this.selected = null;
                }
            }).catch((error) => {
                this.loading = false;
                console.log(error);
            });
        },

        hide() {
            this.query = null;
            this.results = {};
            this.selected = null;
        },

        redirect() {
            if (this.selected) {
                window.location = this.selected.url;
            }
        },

        move(direction) {
            if (false === this.hasResults) {
                this.selected = null;
                return;
            }

            let posts = this.results.posts;
            let current = this.selected ? posts.indexOf(this.selected) : null;
            let last = posts.length - 1;

            if (direction === 'down') {
                this.selected = (current === null || current === last) ? posts[0] : posts[current + 1];
            }

            if (direction === 'up') {
                this.selected = (current === null || current === 0) ? posts[last] : posts[current - 1];
            }
        },
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
