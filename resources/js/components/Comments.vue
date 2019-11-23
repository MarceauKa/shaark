<template>
    <div class="card card--comments">
        <div class="card-header d-flex justify-content-between">
            {{ __('Comments') }}
            <span class="d-block badge text-white"
                  :class="{'badge-info': count > 0, 'badge-default': count === 0}"
            >{{ count }}</span>
        </div>

        <div class="card-body">
            <loader :loading="loading" v-if="loading"></loader>
            <div v-else>
                <div class="alert alert-info mb-0"
                     v-if="comments.length === 0"
                >{{ __('No comments') }}</div>

                <comment v-for="comment in comments"
                         :comment="comment"
                         :key="comment.id"
                ></comment>
            </div>
        </div>

        <div class="card-footer" v-if="canAddComment">
            <h5 class="card-title d-flex justify-content-between flex-wrap">
                {{ __('New comment') }}
                <small v-if="comment.comment">
                    <i class="fas fa-reply mr-1"></i> {{ __('Replying to :name', {name: comment.comment.name}) }}
                </small>
            </h5>

            <div class="row" v-if="false === isLogged()">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               :class="{'is-invalid': hasFormError('name')}"
                               :placeholder="__('Name')"
                               v-model="comment.name"
                               required
                        >
                        <span class="invalid-feedback" v-if="hasFormError('name')">{{ firstFormError('name') }}</span>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <input type="email"
                               class="form-control"
                               :class="{'is-invalid': hasFormError('email')}"
                               :placeholder="__('E-Mail Address')"
                               v-model="comment.email"
                               required
                        >
                        <span class="invalid-feedback" v-if="hasFormError('email')">{{ firstFormError('email') }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <textarea class="form-control"
                          :class="{'is-invalid': hasFormError('content')}"
                          :placeholder="__('Content')"
                          ref="commentFormContent"
                          v-model="comment.content"
                          required
                ></textarea>
                <span class="invalid-feedback" v-if="hasFormError('content')">{{ firstFormError('content') }}</span>
            </div>

            <button type="button"
                    class="btn btn-primary"
                    @click.prevent="submit"
                    :disabled="loading"
            >{{ __('Save') }}</button>
        </div>
    </div>
</template>

<script>
import formErrors from "../mixins/formErrors";
import httpErrors from "../mixins/httpErrors";

export default {
    mixins: [
        formErrors,
        httpErrors,
    ],

    props: {
        id: {
            type: Number,
            required: true,
        },
        allowGuest: {
            type: Boolean,
            required: false,
            default: true,
        }
    },

    mounted() {
        this.fetch();

        this.$bus.$on('reply', (comment) => {
            this.comment.comment = comment;
        });

        this.$bus.$on('moderate', (comment) => {
            this.moderate(comment);
        });

        this.$bus.$on('delete', (comment) => {
            this.delete(comment);
        });

        this.initFromStorage();
    },

    data() {
        return {
            loading: true,
            count: 0,
            comments: [],
            comment: {
                comment: null,
                content: '',
                name: null,
                email: null,
            }
        }
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get(`/api/comments/${this.id}`)
                .then(response => {
                    this.count = response.data.comments.length || 0;
                    this.comments = this.nested(response.data.comments);
                    this.loading = false;
                })
                .catch(error => {
                    this.setHttpError(error);
                    this.toastHttpError();
                    this.loading = false;
                });
        },

        submit() {
            this.loading = true;

            axios.post(`/api/comments/${this.id}`, {
                name: this.comment.name,
                email: this.comment.email,
                content: this.comment.content,
                reply: this.comment.comment ? this.comment.comment.id : null
            })
                .then(response => {
                    this.loading = false;
                    this.$toasted.success(response.data.message);
                    this.resetFormError();
                    this.comment.content = null;
                    this.comment.comment = null;
                    this.fetch();
                })
                .catch(error => {
                    this.setFormError(error);
                    this.setHttpError(error);
                    this.toastHttpError();
                    this.loading = false;
                });
        },

        moderate(comment) {
            this.loading = true;

            axios.post(`/api/comments/${this.id}/moderate/${comment.id}`)
                .then(response => {
                    this.loading = false;
                    this.$toasted.success(response.data.message);
                    this.fetch();
                })
                .catch(error => {
                    this.setHttpError(error);
                    this.toastHttpError();
                    this.loading = false;
                });
        },

        delete(comment) {
            this.loading = true;

            axios.delete(`/api/comments/${this.id}/${comment.id}`)
                .then(response => {
                    this.loading = false;
                    this.$toasted.success(response.data.message);
                    this.fetch();
                })
                .catch(error => {
                    this.setHttpError(error);
                    this.toastHttpError();
                    this.loading = false;
                });
        },

        nested(items, id = null, link = 'comment_id') {
            return items
                .filter(item => item[link] === id)
                .map(item => ({...item, comments: this.nested(items, item.id)}));
        },

        removeReply() {
            this.comment.comment = null;
        },

        initFromStorage() {
            let storage = JSON.parse(localStorage.getItem('comment'));
            if (storage !== null) {
                if (false === this.isLogged()) {
                    this.comment.name = storage.name || null;
                    this.comment.email = storage.email || null;
                }
            }
        },

        commentToStorage() {
            localStorage.setItem('comment', JSON.stringify({
                name: this.comment.name,
                email: this.comment.email,
            }));
        },
    },

    watch: {
        'comment.comment': function (value) {
            this.$refs.commentFormContent.focus();
        },
        'comment.name': _.debounce(function (value) {
            this.commentToStorage();
        }, 200),
        'comment.email': _.debounce(function (value) {
            this.commentToStorage();
        }, 200),
    },

    computed: {
        canAddComment() {
            return this.isLogged() || this.allowGuest;
        }
    }
}
</script>
