module.exports = {
    data: function () {
        return {
            hasChanged: false,
            auditForm: null,
        }
    },

    methods: {
        startAudit() {
            this.clearAudit();
            this.registerUnloadingPrevention();
            this.auditForm = JSON.parse(JSON.stringify(this.form));
        },

        clearAudit() {
            this.hasChanged = false;
            this.auditForm = null;
        },

        registerUnloadingPrevention() {
            window.addEventListener('beforeunload', (event) => {
                if (this.hasChanged === true) {
                    event.stopPropagation();
                    event.preventDefault();
                    event.returnValue = '';
                }
            });
        }
    },

    watch: {
        'form': {
            handler: function (value, old) {
                let changed = false;
                const hasChanged = (newValue, originalValue) => {
                    if (typeof newValue === 'object') {
                        return JSON.stringify(newValue) !== JSON.stringify(originalValue);
                    }

                    return newValue !== originalValue;
                };

                Object.keys(value).forEach((key) => {
                    if (hasChanged(value[key], this.auditForm[key])) {
                        changed = true;
                    }
                });

                this.hasChanged = changed;
            },
            deep: true
        }
    },
};
