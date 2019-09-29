<template>
    <div class="card card--chest mb-4" :class="{'card-single': single, 'card-index': !single}">
        <div class="card-body">
            <h5 class="card-title">
                <span>{{ __('Chest') }}</span> &mdash; <a :href="chest.permalink">{{ chest.title }}</a>
            </h5>

            <div class="card-reduce">
                <chest-lines :preview="chest.content"></chest-lines>
            </div>

            <p class="card-text mt-1" v-if="chest.tags.length > 0">
                <a v-for="tag in chest.tags" class="badge badge-secondary" :href="`/tag/${tag}`">{{ tag }}</a>
            </p>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <span>{{ chest.is_private ? '🔒 ' : '' }}{{ chest.date_formated }}</span>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" :href="chest.permalink">{{ __('Permalink') }}</a>
                    <h6 class="dropdown-header" v-if="chest.editable">{{ __('Manage') }}</h6>
                    <a class="dropdown-item" :href="chest.url_edit" v-if="chest.editable">{{ __('Edit') }}</a>
                    <confirm class="dropdown-item" :text="__('Delete')" :text-confirm="__('Confirm')" @confirmed="remove" v-if="chest.editable"></confirm>
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
                    console.log(error);
                    this.$toasted.error(this.__("Unable to delete chest"));
                })
        }
    }
}
</script>
