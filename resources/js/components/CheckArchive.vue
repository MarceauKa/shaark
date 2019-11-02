<template>
    <button type="button"
            :class="{'btn-outline-danger': status === 'fail', 'btn-outline-success': status === 'success'}"
            @click="check"
            :disabled="loading"
    >
        <span v-if="!loading && status === null">{{ text }}</span>
        <span v-else-if="status === 'success'">{{ __('Success') }}</span>
        <span v-else-if="status === 'fail'">{{ __('Fail') }}</span>
        <span v-else>
            <div class="spinner-grow spinner-grow-sm" role="status"></div>
        </span>
    </button>
</template>

<script>
import httpErrors from "../mixins/httpErrors";

export default {
    mixins: [
        httpErrors,
    ],

    props: {
        type: {
            type: String,
            required: true
        },
        text: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            loading: false,
            status: null,
        }
    },

    methods: {
        check() {
            this.loading = true;

            axios.get(`/api/manage/archive/check/${this.type}`)
                .then(response => {
                    this.status = response.data.status;
                    this.clear();
                })
                .catch(error => {
                    this.status = 'fail';
                    this.setHttpError(error);
                    this.toastHttpError(this.__('Whoops!'));
                    this.clear();
                })
        },

        clear() {
            this.loading = false;

            setTimeout(() => {
                this.status = null;
            }, 5000);
        }
    }
}
</script>
