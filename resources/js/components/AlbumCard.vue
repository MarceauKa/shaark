<template>
    <div class="card card--album mb-4" :class="{'card-single': single, 'card-index': !single}">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-thumbtack fa-sm pr-1" v-if="album.is_pinned && !single"></i>
                <span>{{ __('Album') }}</span> &mdash; <a :href="album.permalink">{{ album.title }}</a><br>
            </h5>

            <p class="card-content" v-html="album.content"></p>

            <masonry :cols="imagesCols"
                     :gutter="5"
                     v-if="images"
                     class="mb-1"
            >
                <div v-for="image in images" :key="image.name">
                    <img v-img="{src: image.url_full, group: album.permalink}"
                         :src="image.url_thumb || image.url_full"
                         :alt="image.name"
                         class="img-fluid mb-1" />
                </div>
            </masonry>

            <p v-if="!single && album.images.length > 4" class="text-right small mb-0">
                <i class="fas fa-plus mr-1"></i> {{ album.images.length - images.length }}
            </p>

            <p class="card-text mt-1" v-if="album.tags.length > 0">
                <a v-for="tag in album.tags" class="badge badge-secondary mr-1" :href="`/tag/${tag}`">{{ tag }}</a>
            </p>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <span><i class="fas fa-lock pr-2" v-if="album.is_private"></i>{{ album.date_formated }}</span>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More') }}
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" :href="album.permalink"><i class="fas fa-link fa-fw mr-1"></i> {{ __('Permalink') }}</a>

                    <h6 class="dropdown-header" v-if="album.editable">{{ __('Manage') }}</h6>

                    <a class="dropdown-item" @click="$bus.$emit('share', album)" v-if="album.editable"><i class="fas fa-share-square fa-fw mr-1"></i> {{ __('Temp sharing') }}</a>
                    <a class="dropdown-item" :href="album.url_edit" v-if="album.editable"><i class="fas fa-pen-alt fa-fw mr-1"></i> {{ __('Edit') }}</a>

                    <confirm class="dropdown-item"
                             :text="`<i class='fas fa-trash-alt fa-fw mr-1'></i> ${__('Delete')}`"
                             :text-confirm="`<i class='fas fa-check fa-fw mr-1'></i> ${__('Confirm')}`"
                             @confirmed="remove"
                             v-if="album.editable"
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
        album: {
            type: Object,
            required: true,
            default: () => {}
        },
    },

    methods: {
        remove() {
            axios.delete(this.album.url_delete)
                .then(response => {
                    this.$toasted.success(this.__("Album :name has been deleted", {'name': this.album.title}));

                    if (this.single) {
                        window.location = '/';
                    } else {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    this.$toasted.error(this.__("Unable to delete album"));
                })
        }
    },

    computed: {
        images: function () {
            if (this.single) {
                return this.album.images;
            }

            let length = this.album.images.length;
            let max = length > 4 ? 4 : length;
            console.log(length, max);
            return this.album.images.slice(0, max);
        },

        imagesCols: function () {
            if (this.single) {
                return {default: 4, 1000: 3, 700: 2, 400: 1};
            }

            return {default: 2};
        }
    }
}
</script>
