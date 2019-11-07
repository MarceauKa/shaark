<template>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-archive mr-1"></i>
            {{ __('Archives') }}
        </div>

        <div class="card-body" v-if="!loading">
            <div class="alert alert-info" v-if="archives.length === 0">
                {{ __('No archive') }}
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-borderless table-sm">
                    <thead>
                    <tr>
                        <th>{{ __('Link') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="archive in archives">
                        <td class="align-middle">
                        <span v-if="['pdf'].indexOf(archive.extension) !== -1">
                            <i class="fas fa-file-pdf mr-1"></i>
                        </span>
                            <span v-else-if="['mp4', 'webm', 'mpeg', 'avi', 'mkv'].indexOf(archive.extension) !== -1">
                            <i class="fas fa-file-video mr-1"></i>
                        </span>
                            <span v-else-if="['mp3', 'wav', 'flac'].indexOf(archive.extension) !== -1">
                            <i class="fas fa-file-audio mr-1"></i>
                        </span>
                            <span v-else>
                            <i class="fas fa-file mr-1"></i>
                        </span>

                            <a :href="archive.permalink">
                                {{ archive.title.substr(0, 40) }}
                                <span v-if="archive.title.lenght >= 40">...</span>
                            </a>

                            <small class="text-muted">{{ archive.size }}</small>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('More') }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" :href="archive.url_download">
                                        <i class="fas fa-file-download fa-fw mr-1"></i> {{ __('Download archive') }}
                                    </a>
                                    <confirm class="dropdown-item"
                                             :text="`<i class='fas fa-trash-alt fa-fw mr-1'></i> ${__('Delete')}`"
                                             :text-confirm="`<i class='fas fa-check fa-fw mr-1'></i> ${__('Confirm')}`"
                                             @confirmed="deleteArchive(archive)"
                                    ></confirm>
                                </div>
                            </div>
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
            archives: [],
            loading: true,
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get('/api/manage/archives')
                .then(response => {
                    this.archives = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.setHttpError(error);
                    this.toastHttpError(this.__("Can't fetch archives"));
                })
        },

        deleteArchive(archive) {
            axios.delete(archive.url_archive)
                .then(response => {
                    this.$toasted.success(response.data.message);
                    this.fetch();
                })
                .catch(error => {
                    this.setHttpError(error);
                    this.toastHttpError(this.__('Whoops!'));
                });
        }
    },
}
</script>
