<template>
    <div class="card card--link mb-4" :class="{'card-single': single, 'card-index': !single}">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-thumbtack fa-sm pr-1" v-if="link.is_pinned && !single"></i>
                <span>{{ __('Link') }}</span> &mdash; <a :href="link.permalink">{{ link.title }}</a><br>
                <a :href="link.url" class="small text-muted">{{ displayUrl }}</a>
            </h5>

            <p class="card-content" v-html="link.content"></p>

            <div class="card-preview mb-1" v-html="link.preview" v-if="link.preview"></div>

            <p class="card-text mt-1" v-if="link.tags.length > 0">
                <a v-for="tag in link.tags" class="badge badge-secondary mr-1" :href="`/tag/${tag}`">{{ tag }}</a>
            </p>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <span><i class="fas fa-lock pr-2" v-if="link.is_private"></i>{{ link.date_formated }}</span>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More') }}
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" :href="link.permalink"><i class="fas fa-link fa-fw mr-1"></i> {{ __('Permalink') }}</a>
                    <a class="dropdown-item" :href="link.url_download" v-if="link.url_download"><i class="fas fa-file-download fa-fw mr-1"></i> {{ __('Download archive') }}</a>

                    <h6 class="dropdown-header" v-if="link.editable">{{ __('Manage') }}</h6>

                    <a class="dropdown-item" @click="$bus.$emit('share', link)" v-if="link.editable"><i class="fas fa-share-square fa-fw mr-1"></i> {{ __('Temp sharing') }}</a>
                    <a class="dropdown-item" :href="link.url_edit" v-if="link.editable"><i class="fas fa-pen-alt fa-fw mr-1"></i> {{ __('Edit') }}</a>

                    <confirm class="dropdown-item"
                             :text="`<i class='fas fa-trash-alt fa-fw mr-1'></i> ${__('Delete')}`"
                             :text-confirm="`<i class='fas fa-check fa-fw mr-1'></i> ${__('Confirm')}`"
                             @confirmed="remove"
                             v-if="link.editable"
                    ></confirm>
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
                    this.$toasted.error(this.__("Unable to delete link"));
                })
        }
    },

    computed: {
        displayUrl: function () {
            let url = this.link.url;
            let length = url.length;

            if (length > 65) {
                let displayUrl = url.substr(0, 62);
                return `${displayUrl}...`;
            }

            return url;
        }
    }
}
</script>
