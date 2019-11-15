<template>
    <form class="form-inline">
        <div class="search-input-wrapper">
            <input class="form-control"
                   type="search"
                   ref="input"
                   :placeholder="__('Type / to search')"
                   v-model="query"
                   @focus="focused = true"
                   @blur="focused = false"
                   @keydown.down.stop="move('down')"
                   @keydown.up.stop="move('up')"
                   @keydown.enter.prevent.stop="choose"
            >
            <div class="spinner-border spinner-border-sm text-info" role="status" v-if="loading"></div>
            <span class="badge badge-info text-white" role="status" v-if="displayNoResultIndicator">
                {{ __('No result') }}
            </span>
        </div>

        <div class="list-group results mt-1"
             :class="{'active': hasResults || displaySearchHistory}"
             v-on-clickaway="hide"
        >
            <a class="list-group-item list-group-item-action"
               :class="{'active': selected === item}"
               v-for="item in history"
               v-if="displaySearchHistory"
            >
                <span><i class="fas fa-history fa-fw mr-1"></i> {{ item }}</span>
            </a>

            <div class="list-group-item"
                v-if="hasTagsResults"
            >
                <div><i class="fas fa-tags"></i> {{ __('Tags') }}</div>
                <div>
                    <a v-for="result in results.tags"
                       class="btn btn-primary btn-sm mr-1"
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
            history: [],
            focused: false,
        }
    },

    mounted() {
        this.fetchHistory();

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
                    this.addHistory(this.query);
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

        choose() {
            if (this.selected && this.displaySearchHistory) {
                this.query = this.selected;
            }

            if (this.selected && this.hasResults) {
                window.location = this.selected.url;
            }
        },

        move(direction) {
            if (this.displaySearchHistory) {
                this.moveIn(this.history, direction);
                return;
            }

            if (this.hasResults) {
                this.moveIn(this.results.posts, direction);
                return;
            }

            this.selected = null;
        },

        moveIn(items, direction) {
            let current = this.selected ? items.indexOf(this.selected) : null;
            let last = items.length - 1;

            if (direction === 'down') {
                this.selected = (current === null || current === last) ? items[0] : items[current + 1];
            }

            if (direction === 'up') {
                this.selected = (current === null || current === 0) ? items[last] : items[current - 1];
            }
        },

        fetchHistory() {
            let storage = localStorage.getItem('searchHistory') || null;

            if (storage) {
                try {
                    this.history = JSON.parse(storage);
                } catch (e) {
                    console.log('Unable to parse search history from local storage');
                }
            }
        },

        addHistory(query) {
            if (false === this.hasResults) {
                return;
            }

            if (this.history.indexOf(query) === -1) {
                this.history.unshift(query);
                this.history = this.history.slice(0, 5);

                localStorage.setItem('searchHistory', JSON.stringify(this.history));
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
        },

        displaySearchHistory() {
            return this.history.length > 0
                && this.query === null
                && this.focused;
        },

        displayNoResultIndicator() {
            return this.query !== null
                && this.query.length >= 3
                && this.loading === false
                && false === this.hasResults;
        }
    },

    watch: {
        query: _.debounce(function (value) {
            if (value && value.length >= 3) {
                this.search(value)
            }

            if (value.length === 0) {
                this.hide();
            }
        }, 200),
    }
}
</script>
