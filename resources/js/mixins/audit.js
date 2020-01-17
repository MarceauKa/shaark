module.exports = {
    data: function () {
        return {
            preventUnload: false,
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
            this.preventUnload = false;
            this.auditForm = null;
        },

        registerUnloadingPrevention() {
            window.addEventListener('beforeunload', (event) => {
                if (this.preventUnload === true) {
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
                const valueComparator = (newValue, originalValue) => {
                    if (typeof newValue === 'object') {
                        return true;
                    }
                    
                    return newValue === originalValue;
                };

                Object.keys(value).forEach((key) => {
                    if (false === valueComparator(value[key], this.auditForm[key])) {
                        changed = true;
                    }
                });

                this.preventUnload = changed;
            },
            deep: true
        }
    },
};
