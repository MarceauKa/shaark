<template>
    <form class="form-inline w-100 px-3">
        <input class="form-control w-100" type="search"
               placeholder="Tapez / pour chercher" v-model="query">
        <div class="list-group results" :class="{'active': results.length > 0}">
            <a v-for="result in results"
               href="#" class="list-group-item list-group-item-action">
                <p class="mb-0"><strong>{{ result.title }}</strong></p>
                <p class="mb-0">{{ result.content }}</p>
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
            results: [],
            loading: false,
        }
    },

    mounted() {
    },

    methods: {
        search() {
            this.loading = true;

            axios.post(this.url, {
                query: this.query
            }).then((response) => {
                this.loading = false;

                if (response.status === 200) {
                    this.results = response.data.data;
                }
            }).catch((error) => {
                this.loading = false;
                console.log(error);
            });
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

<style scoped>
    .form-inline {
        position: relative;
    }
    .results {
        z-index: 500;
        position: absolute;
        top: 40px;
        width: auto;
        display: none;
    }
    .results.active {
        display: block;
    }
</style>
