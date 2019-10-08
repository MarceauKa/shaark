<template>
    <div class="card card--story mb-4" :class="{'card-single': single, 'card-index': !single}">
        <div class="card-body">
            <h5 class="card-title">
                <span>{{ __('Story') }}</span> &mdash; <a :href="story.url">{{ story.title }}</a>
            </h5>

            <div class="card-text card-reduce" v-if="previewLayout">
                <vue-markdown>{{ story.content }}</vue-markdown>
            </div>

            <p class="card-text mt-1" v-if="story.tags.length > 0">
                <a v-for="tag in story.tags" :key="tag.id" class="badge badge-secondary" :href="`/tag/${tag}`">{{ tag }}</a>
            </p>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <span>{{ story.is_private ? '🔒 ' : '' }}{{ story.date_formated }}</span>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" :href="story.url">{{ __('Permalink') }}</a>
                    <h6 class="dropdown-header" v-if="story.editable">{{ __('Manage') }}</h6>
                    <a class="dropdown-item" :href="story.url_edit" v-if="story.editable">{{ __('Edit') }}</a>
                    <confirm class="dropdown-item" :text="__('Delete')" :text-confirm="__('Confirm')" @confirmed="remove" v-if="story.editable"></confirm>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        single: {
            type: Boolean,
            required: false,
            default: false,
        },
        story: {
            type: Object,
            required: true,
            default: () => {}
        },
    },

    computed: {
        previewLayout() {
            return localStorage.getItem('layout') !== 'simple';
        }
    },

    methods: {
        remove() {
            axios.delete(this.story.url_delete)
                .then(response => {
                    this.$toasted.success(this.__("Story :name has been deleted", {'name': this.story.title}));

                    if (this.single) {
                        window.location = '/';
                    } else {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.$toasted.error(this.__("Unable to delete story"));
                })
        }
    }
}
</script>
