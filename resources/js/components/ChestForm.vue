<template>
    <div class="card card--chest">
        <div class="card-body">
            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control" :class="{'is-invalid': hasFormError('title')}" id="title" v-model="form.title" :disabled="loading">
                <span class="invalid-feedback" v-if="hasFormError('title')">{{ firstFormError('title') }}</span>
            </div>

            <div class="form-group">
                <label>{{ __('Content') }}</label>
                <chest-lines v-model="form.content"></chest-lines>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_pinned" v-model="form.is_pinned" :disabled="loading">
                    <label class="custom-control-label" for="is_pinned" dusk="chest-form-pinned">{{ __('Is pinned?') }}</label>
                </div>
            </div>

            <div class="form-group">
                <label>{{ __('Tags') }}</label>
                <tags v-model="form.tags"></tags>
            </div>
        </div>

        <div class="card-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" @click.prevent="submit('edit')" :disabled="loading" dusk="chest-form-save">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    {{ __('Save') }}
                </button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu">
                    <button type="button" class="dropdown-item" @click.prevent="submit('view')">{{ __('Save & View') }}</button>
                    <button type="button" class="dropdown-item" @click.prevent="submit('new')">{{ __('Save & New') }}</button>
                </div>
            </div>
            <a :href="chest.permalink" class="btn btn-outline-primary" v-if="chest">{{ __('View')}}</a>
        </div>
    </div>
</template>

<script>
let defaultChest = function () {
    return {
        title: '',
        content: [],
        is_pinned: false,
        tags: [],
    };
};

import httpErrors from "../mixins/httpErrors";
import formErrors from "../mixins/formErrors";

export default {
    mixins: [
        formErrors,
        httpErrors,
    ],

    props: {
        chest: {
            type: Object,
            required: false,
            default: () => {}
        },
    },

    data() {
        return {
            form: defaultChest(),
            loading: false
        }
    },

    mounted() {
        if (this.chest) {
            this.form = this.chest;
        }
    },

    methods: {
        submit(then) {
            this.loading = true;

            axios.request({
                method: this.chest ? 'PUT' : 'POST',
                url: this.chest ? this.chest.url_update : '/api/chest',
                data: this.form
            }).then(response => {
                this.$toasted.success(this.__('Saved'));

                if (then !== 'edit') {
                    window.location = then === 'new' ? '/chest/create' : response.data.post.url;
                } else {
                    this.loading = false;
                    this.resetFormError();
                }
            }).catch(error => {
                this.loading = false;
                this.setFormError(error);
                this.setHttpError(error);
                this.toastHttpError(this.__("Can't save"));
            })
        }
    }
}
</script>
