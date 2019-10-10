const error = {
    data: function () {
        return {
            errors: {},
        }
    },

    methods: {
        setErrors(errors) {
            this.errors = errors;
        },

        hasError(key) {
            return this.errors.hasOwnProperty(key);
        },

        firstError(key) {
            return this.hasError(key) ? this.errors[key][0] : null;
        }
    }
};

export default error;
