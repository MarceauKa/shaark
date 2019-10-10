const formErrors = {
    data: function () {
        return {
            formErrors: {},
        }
    },

    methods: {
        setFormError(error) {
            this.formErrors = error.response.data.errors;
        },

        hasFormError(key) {
            return this.formErrors.hasOwnProperty(key);
        },

        firstFormError(key) {
            return this.hasFormError(key) ? this.formErrors[key][0] : null;
        },

        resetFormError() {
            this.formErrors = {};
        }
    }
};

export default formErrors;
