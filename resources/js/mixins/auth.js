module.exports = {
    methods: {
        isLogged() {
            return this.user() !== null;
        },

        user() {
            return window.user || null;
        },
    },
};
