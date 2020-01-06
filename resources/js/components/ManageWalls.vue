<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-bookmark mr-1"></i> {{ __('Walls') }}
            </span>
            <button class="btn btn-primary btn-sm text-white" @click.prevent="create">{{ __('Add') }}</button>
        </div>

        <div class="card-body" v-if="!loading">
            <div class="alert alert-info" v-if="walls.length === 0">
                {{ __('No wall') }}
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-borderless table-sm">
                    <thead>
                    <tr>
                        <th><i class="fas fa-star"></i></th>
                        <th><i class="fas fa-lock"></i></th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Tags') }}</th>
                        <th>{{ __('Cards') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="wall in walls">
                        <td v-if="wall.is_default"><i class="fa fa-star"></i></td>
                        <td v-else>-</td>
                        <td v-if="wall.is_private"><i class="fa fa-lock"></i></td>
                        <td v-else>-</td>
                        <td>
                            {{ wall.title }}
                        </td>
                        <td>{{ listRestrictions(wall.restrict_tags) }}</td>
                        <td>{{ listRestrictions(wall.restrict_cards) }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                        type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                >
                                    {{ __('More') }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#"
                                       @click.prevent="edit(wall)"
                                    >
                                        <i class="fas fa-pen-alt fa-fw mr-1"></i> {{ __('Edit') }}
                                    </a>

                                    <confirm class="dropdown-item"
                                             :text="`<i class='fas fa-trash-alt fa-fw mr-1'></i> ${__('Delete')}`"
                                             :text-confirm="`<i class='fas fa-check fa-fw mr-1'></i> ${__('Confirm')}`"
                                             @confirmed="remove(wall)"
                                    ></confirm>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <modal :open="open" @closed="open = false">
                <template #header>{{ form && form.id ? __('Edit') : __('Create') }}</template>
                <template #content>
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text"
                               id="title"
                               v-model="form.title"
                               class="form-control"
                               :class="{'is-invalid': hasFormError('title')}"
                               required
                        >
                        <span class="invalid-feedback" v-if="hasFormError('title')">{{ firstFormError('title') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input type="text"
                               id="slug"
                               v-model="form.slug"
                               class="form-control"
                               :class="{'is-invalid': hasFormError('slug')}"
                               required
                        >
                        <span class="invalid-feedback" v-if="hasFormError('slug')">{{ firstFormError('slug') }}</span>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Restrict tags') }}</label>
                        <tags v-model="form.restrict_tags"></tags>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Restrict cards') }}</label>
                        <select class="form-control"
                                id="restrict_cards"
                                v-model="form.restrict_cards"
                                :class="{'is-invalid': hasFormError('restrict_cards')}"
                                multiple
                        >
                            <option value="link">{{ __('Link') }}</option>
                            <option value="story">{{ __('Story') }}</option>
                            <option value="album">{{ __('Album') }}</option>
                            <option value="chest">{{ __('Chest') }}</option>
                        </select>
                        <span class="invalid-feedback" v-if="hasFormError('restrict_cards')">{{ firstFormError('restrict_cards') }}</span>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Columns to show') }}</label>
                        <input type="number"
                               id="columns_count"
                               class="form-control"
                               :class="{'is-invalid': hasFormError('columns')}"
                               v-model="form.appearance.columns"
                               step="1"
                               min="1"
                               max="4"
                        >
                        <span class="invalid-feedback" v-if="hasFormError('columns')">{{ firstFormError('columns') }}</span>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="show_tags" v-model="form.appearance.show_tags">
                                    <label class="custom-control-label" for="show_tags">{{ __('Show tags') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="compact" v-model="form.appearance.compact">
                                    <label class="custom-control-label" for="compact">{{ __('Compact cards list') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_private" v-model="form.is_private" :disabled="loading">
                                    <label class="custom-control-label" for="is_private" dusk="wall-form-private">{{ __('Is private?') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_default" v-model="form.is_default" :disabled="loading">
                                    <label class="custom-control-label" for="is_default" dusk="wall-form-private">{{ __('Is default?') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-outline-primary" @click.prevent="submit" :disabled="loading">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                            {{ __('Save') }}
                        </button>
                    </div>
                </template>
            </modal>
        </div>
        <div class="card-body" v-else>
            <loader :loading="loading"></loader>
        </div>
    </div>
</template>

<script>
import httpErrors from "../mixins/httpErrors";
import formErrors from "../mixins/formErrors";

export default {
    mixins: [
        formErrors,
        httpErrors
    ],

    data() {
        return {
            walls: [],
            loading: true,
            open: false,
            form: null,
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get('/api/manage/walls')
                .then(response => {
                    this.walls = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    this.setHttpError(error);
                    this.toastHttpError(this.__("Can't fetch walls"));
                })
        },

        create() {
            this.form = {
                title: '',
                slug: '',
                restrict_tags: [],
                restrict_cards: [],
                appearance: [],
                is_default: false,
                is_private: false,
            };
            this.open = true;
        },

        edit(wall) {
            this.form = wall;
            this.open = true;
        },

        submit() {
            let form = this.form.id ? {
                    title: this.form.title,
                    slug: this.form.slug,
                    appearance: this.form.appearance,
                    is_default: this.form.is_default,
                    is_private: this.form.is_private,
                    restrict_tags: this.form.restrict_tags,
                    restrict_cards: this.form.restrict_cards,
            } : this.form;

            axios.request({
                method: this.form.id ? 'PUT' : 'POST',
                url: this.form.id ? `/api/manage/walls/${this.form.id}` : '/api/manage/walls',
                data: form
            })
                .then(response => {
                    this.open = false;
                    this.$toasted.success(this.__("Saved"));
                    this.resetFormError();
                    window.location.reload();
            })
                .catch(error => {
                    this.setFormError(error);
                    this.setHttpError(error);
                    this.toastHttpError(this.__("Can't save"));
                })
        },

        remove(wall) {
            this.loading = true;

            axios.delete(`/api/manage/walls/${wall.id}`).then(response => {
                this.$toasted.success(this.__("Deleted"));
                window.location.reload();
            }).catch(error => {
                this.loading = false;
                this.setHttpError(error);
                this.toastHttpError(this.__("Can't delete"));
            })
        },

        listRestrictions(list) {
            if (list && list.length > 0) {
                return list.join(', ');
            }

            return '-';
        }
    },

    watch: {
        'form.title': {
            handler: function (after) {
                let slug = after.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

                if (slug !== this.form.slug) {
                    this.form.slug = slug;
                }
            },
            deep: true
        }
    }
}
</script>
