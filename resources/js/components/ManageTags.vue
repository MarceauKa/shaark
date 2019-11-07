<template>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-tags mr-1"></i>
            {{ __('Tags') }}
        </div>

        <div class="card-body" v-if="!loading">
            <div class="alert alert-info" v-if="tags.length === 0">
                {{ __('No tag') }}
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-borderless table-sm">
                    <thead>
                    <tr>
                        <th class="w-25">{{ __('Name') }}</th>
                        <th class="w-25">{{ __('Posts') }}</th>
                        <th class="w-50">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="tag in tags">
                        <td class="align-middle">
                            <a :href="tag.url">{{ tag.name }}</a>
                        </td>
                        <td class="align-middle">{{ tag.posts_count }}</td>
                        <td class="d-flex justify-content-between">
                            <select name="tag" id="tag" class="form-control custom-select mr-1 w-auto flex-grow-1" @change="move(tag.name, $event.target.value)">
                                <option value="none">-- {{ __('Move') }} --</option>
                                <option v-for="item in tags"
                                        :value="item.name"
                                        v-text="item.name"
                                        v-if="tag.name !== item.name"
                                ></option>
                            </select>

                            <confirm tag="button" class="btn btn-danger btn-sm"
                                     :text="__('Delete')"
                                     :text-confirm="__('Confirm')"
                                     @confirmed="remove(tag)"
                            ></confirm>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body" v-else>
            <loader :loading="loading"></loader>
        </div>
    </div>
</template>

<script>
import httpErrors from "../mixins/httpErrors";

export default {
    mixins: [
        httpErrors
    ],

    data() {
        return {
            tags: [],
            loading: true,
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get('/api/manage/tags')
                .then(response => {
                    this.tags = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.setHttpError(error);
                    this.toastHttpError(this.__("Can't fetch tags"));
                })
        },

        move(from, to) {
            if (to === 'none') {
                return;
            }

            if (confirm(this.__("All elements tagged :from will be moved to :to. Selected tag will be deleted. Are you sure?", {from, to}))) {
                this.loading = true;

                axios.post(`/api/manage/tags/${from}/move/${to}`).then(response => {
                    this.$toasted.success(this.__("Elements tagged :from have been moved to :to.", {from: from, to: to}));
                    this.fetch();
                }).catch(error => {
                    console.log(error);
                })
            }
        },

        remove(tag) {
            this.loading = true;

            axios.delete(`/api/manage/tags/${tag.name}`).then(response => {
                this.$toasted.success(this.__("Tag :name has been deleted", {name: tag.name}));
                this.fetch();
            }).catch(error => {
                console.log(error);
            })
        },
    },
}
</script>
