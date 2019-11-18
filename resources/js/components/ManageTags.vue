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
                        <th>{{ __('Posts') }}</th>
                        <th class="w-50">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="tag in tags">
                        <td class="align-middle">
                            <div v-if="editing !== null && editing.id === tag.id">
                                <input type="text" class="form-control" :id="`input${tag.id}`" v-model="edit" />
                            </div>
                            <div v-else>
                                <a :href="`/tag/${tag.name}`">{{ tag.name }}</a>
                            </div>
                        </td>
                        <td class="align-middle">{{ tag.posts_count }}</td>
                        <td class="d-flex justify-content-between">
                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm mr-1"
                                    @click.prevent="editing = tag"
                                    :disabled="editing !== null && editing.id !== tag.id"
                                    v-if="editing === null || (editing !== null && editing.id !== tag.id)"
                            >
                                <i class="fas fa-edit"></i>
                            </button>

                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm mr-1"
                                    @click.prevent="rename()"
                                    @keyup.enter.prevent="rename()"
                                    v-else
                            >
                                <i class="fas fa-check"></i>
                            </button>

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
            editing: null,
            edit: null,
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
                    this.$toasted.error(this.__("Can't save"));
                })
            }
        },

        remove(tag) {
            this.loading = true;

            axios.delete(`/api/manage/tags/${tag.name}`).then(response => {
                this.$toasted.success(this.__("Deleted"));
                this.fetch();
            }).catch(error => {
                this.$toasted.error(this.__("Can't delete"));
            })
        },

        rename() {
            if (this.editing.name !== this.edit) {
                axios.put(`/api/manage/tags/${this.editing.name}/rename/${this.edit}`).then(response => {
                    this.$toasted.success(this.__("Saved"));
                    this.fetch();
                }).catch(error => {
                    this.$toasted.error(this.__("Can't save"));
                })
            }

            this.editing = null;
            this.edit = null;
        }
    },

    watch: {
        editing: function (tag) {
            if (tag !== null) {
                this.$nextTick(() => {
                    this.edit = tag.name;
                    let selector = `input#input${tag.id}`;
                    document.querySelector(selector).focus();
                });
            }

            this.edit = null;
        }
    }
}
</script>
