<template>
    <div class="card card--link mb-4" :class="{'card-single': single, 'card-index': !single}">
        <div class="card-body">
            <h5 class="card-title">
                <span>{{ __('Link') }}</span> &mdash; <a :href="link.url">{{ link.title }}</a>
            </h5>

            <div class="card-reduce" v-if="previewLayout">
                <p class="card-text" v-html="link.content"></p>
                <div class="card-preview mb-1" v-html="link.preview" v-if="link.preview"></div>
            </div>

            <p class="card-text mt-1" v-if="link.tags.length > 0">
                <a v-for="tag in link.tags" :key="tag.id" class="badge badge-secondary" :href="`/tag/${tag}`">{{ tag }}</a>
            </p>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <span>{{ link.is_private ? '🔒 ' : '' }}{{ link.date_formated }}</span>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" :href="link.permalink">{{ __('Permalink') }}</a>
                    <a class="dropdown-item" :href="link.url_download" v-if="link.url_download">{{ __('Download archive') }}</a>
                    <h6 class="dropdown-header" v-if="link.editable">{{ __('Manage') }}</h6>
                    <a class="dropdown-item" :href="link.url_archive" v-if="link.editable">{{ __('Manage archive') }}</a>
                    <confirm class="dropdown-item" :text="__('Update preview')" :text-confirm="__('Confirm')" @confirmed="preview" v-if="link.editable"></confirm>
                    <a class="dropdown-item" :href="link.url_edit" v-if="link.editable">{{ __('Edit') }}</a>
                    <confirm class="dropdown-item" :text="__('Delete')" :text-confirm="__('Confirm')" @confirmed="remove" v-if="link.editable"></confirm>
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
        link: {
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
            axios.delete(this.link.url_delete)
                .then(response => {
                    this.$toasted.success(this.__("Link :name has been deleted", {'name': this.link.title}));

                    if (this.single) {
                        window.location = '/';
                    } else {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.$toasted.error(this.__("Unable to delete link"));
                })
        },

        preview() {
            axios.put(this.link.url_preview)
                .then(response => {
                    this.$toasted.success(this.__("Link preview has been updated"));
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                    this.$toasted.error(this.__("Unable to update link preview"));
                })
        }
    }
}
</script>
