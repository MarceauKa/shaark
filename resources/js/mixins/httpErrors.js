const httpErrors = {
    data: function () {
        return {
            httpError: {},
        }
    },

    methods: {
        setHttpError(error) {
            this.httpError = error.response.data.message || null;
        },

        hasHttpError(key) {
            return this.httpError;
        },

        getHttpError(defaultMessage = null) {
            return this.hasHttpError() ? this.httpError : defaultMessage;
        },

        toastHttpError(defaultMessage = null) {
            let message = this.getHttpError(defaultMessage);
            this.$toasted.error(message);
        }
    }
};

export default httpErrors;
