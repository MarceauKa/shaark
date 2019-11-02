<template>
    <div class="card card--album">
        <div class="card-body">
            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control" :class="{'is-invalid': hasFormError('title')}" id="title" v-model="form.title" :disabled="loading" dusk="album-form-title">
                <span class="invalid-feedback" v-if="hasFormError('title')">{{ firstFormError('title') }}</span>
            </div>

            <div class="form-group">
                <label for="content">{{ __('Content') }}</label>
                <textarea id="content" class="form-control" :class="{'is-invalid': hasFormError('content')}" v-model="form.content" :disabled="loading" dusk="album-form-content"></textarea>
                <span class="invalid-feedback" v-if="hasFormError('content')">{{ firstFormError('content') }}</span>
            </div>

            <div class="form-group">
                <label for="content">{{ __('Images') }}</label>

                <file-pond :allow-multiple="true"
                           :allow-browse="true"
                           :instant-upload="true"
                           :label-idle="__('Drop files or click to choose')"
                           :label-invalid-field="__('Fichier invalide')"
                           :label-file-loading="__('Loading')"
                           :label-file-load-error="__('Fail')"
                           :label-file-processing-error="__('Fail')"
                           @init="initUpload"
                           @processfile="handleFileProcess"
                           ref="pond"
                           v-if="album"
                />

                <div class="alert alert-info" v-else>
                    {{ __('Create your album to add images') }}
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_private" v-model="form.is_private" :disabled="loading">
                            <label class="custom-control-label" for="is_private" dusk="album-form-private">{{ __('Private album?') }}</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_pinned" v-model="form.is_pinned" :disabled="loading">
                            <label class="custom-control-label" for="is_pinned" dusk="album-form-pinned">{{ __('Is pinned?') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>{{ __('Tags') }}</label>
                <tags v-model="form.tags" dusk="link-form-tags"></tags>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <div>
                <button class="btn btn-primary" @click.prevent="submit" :disabled="loading" dusk="album-form-save">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    {{ __('Save') }}
                </button>

                <a :href="album.permalink" class="btn btn-outline-primary" v-if="album">{{ __('View')}}</a>
            </div>

            <slot name="actions"></slot>
        </div>
    </div>
</template>

<script>
let defaultAlbum = function () {
    return {
        title: null,
        content: null,
        images: [],
        is_private: false,
        is_pinned: false,
        tags: []
    };
};

import formErrors from "../mixins/formErrors";
import httpErrors from "../mixins/httpErrors";
import vueFilePond, { setOptions } from 'vue-filepond';

export default {
    components: {
        FilePond: new vueFilePond(),
    },

    mixins: [
        formErrors,
        httpErrors,
    ],

    props: {
        album: {
            type: Object,
            required: false,
            default: () => {}
        }
    },

    data() {
        return {
            form: defaultAlbum(),
            loading: false,
        }
    },

    mounted() {
        if (this.album) {
            this.form = this.album;
        }
    },

    methods: {
        submit() {
            this.loading = true;

            axios.request({
                method: this.album ? 'PUT' : 'POST',
                url: this.album ? this.album.url_update : '/api/album',
                data: this.form
            }).then(response => {
                window.location = `/album/${response.data.post.postable_id}/edit`
            }).catch(error => {
                this.loading = false;
                this.setFormError(error);
                this.setHttpError(error);
                this.toastHttpError(this.__('Unable to save album'));
            })
        },

        initUpload() {
            setOptions({
                server: {
                    url: '/api/album/upload',
                    process: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Authorization': 'Bearer ' + $('meta[name="api-token"]').attr('content')
                        }
                    }
                }
            });
        },

        handleFileProcess(error, file) {
            if (error === null) {
                this.form.images.push(file.serverId);
            }
        }
    },
}
</script>
