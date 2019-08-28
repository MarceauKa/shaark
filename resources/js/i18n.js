module.exports = {
    methods: {
        __(key, replace) {
            let i18n = window.i18n[key] ? window.i18n[key] : key;
            _.forEach(replace, (value, key) => {
                i18n = i18n.replace(':' + key, value)
            });
            return i18n;
        },
    },
}
