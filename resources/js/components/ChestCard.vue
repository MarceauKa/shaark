<template>
    <div class="card card--chest mb-4" :class="{'card-single': single, 'card-index': !single}">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-thumbtack fa-sm pr-1" v-if="chest.is_pinned && !single"></i>
                <span>{{ __('Chest') }}</span> &mdash; <a :href="chest.permalink">{{ chest.title }}</a>
            </h5>

            <div class="card-content">
                <chest-lines :preview="chest.content"></chest-lines>
            </div>

            <p class="card-text mt-1" v-if="chest.tags.length > 0">
                <a v-for="tag in chest.tags" class="badge badge-secondary mr-1" :href="`/tag/${tag}`">{{ tag }}</a>
            </p>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <span><i class="fas fa-lock pr-2" v-if="chest.is_private"></i>{{ chest.date_formated }}</span>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More') }}
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" :href="chest.permalink"><i class="fas fa-link fa-fw mr-1"></i> {{ __('Permalink') }}</a>

                    <h6 class="dropdown-header" v-if="chest.editable">{{ __('Manage') }}</h6>

                    <a class="dropdown-item" @click="$bus.$emit('share', chest)" v-if="chest.editable"><i class="fas fa-share-square fa-fw mr-1"></i> {{ __('Temp sharing') }}</a>
                    <a class="dropdown-item" :href="chest.url_edit" v-if="chest.editable"><i class="fas fa-pen-alt fa-fw mr-1"></i> {{ __('Edit') }}</a>

                    <confirm class="dropdown-item"
                             :text="`<i class='fas fa-trash-alt fa-fw mr-1'></i> ${__('Delete')}`"
                             :text-confirm="`<i class='fas fa-check fa-fw mr-1'></i> ${__('Confirm')}`"
                             @confirmed="remove"
                             v-if="chest.editable"
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
        chest: {
            type: Object,
            required: true,
            default: () => {}
        },
    },

    data() {
        return {
            edit: false,
        }
    },

    methods: {
        remove() {
            axios.delete(this.chest.url_delete)
                .then(response => {
                    this.$toasted.success(this.__("Chest :name has been deleted", {'name': this.chest.title}));

                    if (this.single) {
                        window.location = '/';
                    } else {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    this.$toasted.error(this.__("Unable to delete chest"));
                })
        }
    }
}
</script>
