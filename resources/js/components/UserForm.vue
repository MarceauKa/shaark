<template>
    <div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" class="form-control" :class="{'is-invalid': hasFormError('name')}" id="name" v-model="form.name" :disabled="loading">
                    <span class="invalid-feedback" v-if="hasFormError('name')">{{ firstFormError('name') }}</span>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input type="text" class="form-control" :class="{'is-invalid': hasFormError('email')}" id="email" v-model="form.email" :disabled="loading">
                    <span class="invalid-feedback" v-if="hasFormError('email')">{{ firstFormError('email') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input type="password" class="form-control" :class="{'is-invalid': hasFormError('password')}" id="password" v-model="form.password" :disabled="loading">
                    <span class="invalid-feedback" v-if="hasFormError('password')">{{ firstFormError('password') }}</span>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" v-model="form.password_confirmation" :disabled="loading">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" :class="{'is-invalid': hasFormError('is_admin')}" id="is_admin" v-model="form.is_admin" :disabled="loading">
                <label class="custom-control-label" for="is_admin">{{ __('Is admin?') }}</label>
            </div>

            <span class="text-muted">{{ __("Admin users can access settings and other users private content") }}</span>
        </div>

        <button class="btn btn-primary" @click.prevent="submit" :disabled="loading">
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
            {{ __('Save') }}
        </button>
    </div>
</template>

<script>
let defaultUser = function () {
    return {
        name: '',
        email: '',
        is_admin: false,
        password: '',
        password_confirmation: '',
    };
};

import formErrors from '../mixins/formErrors';

export default {
    mixins: [
        formErrors,
    ],

    props: {
        user: {
            type: Object|Boolean,
            required: false,
            default: false,
        }
    },

    data() {
        return {
            form: defaultUser(),
            loading: false,
        }
    },

    mounted() {
        if (this.user) {
            this.setUser(this.user);
        }
    },

    methods: {
        submit() {
            this.loading = true;

            axios.request({
                method: this.user ? 'PUT' : 'POST',
                url: this.user ? this.user.url_update : '/api/manage/users',
                data: this.form
            }).then(response => {
                if (this.user) {
                    this.$toasted.success(this.__("User updated"));
                    this.loading = false;
                } else {
                    this.$toasted.success(this.__("User created"));
                    this.form = defaultUser();
                }

                this.resetFormError();
                this.$emit('submited');
            }).catch(error => {
                if (error.response.data.status === 'error') {
                    this.$toasted.error(error.response.data.message);
                } else {
                    this.$toasted.error(this.__("Unable to save user"));
                }

                this.setFormError(error);
                this.loading = false;
            })
        },

        setUser(user) {
            this.form = defaultUser();
            this.resetFormError();

            if (user) {
                this.form.name = user.name;
                this.form.email = user.email;
                this.form.is_admin = user.is_admin;
            }
        }
    },

    watch: {
        user: function (value) {
            this.setUser(value);
        }
    }
}
</script>
