<template>
    <div>
        <modal :open="open" size="lg" @closed="open = false" v-if="hasNewVersion">
            <template #header>
                <span class="badge badge-success">New</span> {{ version.id }}
            </template>
            <template #content>
                <div v-html="version.changelog"></div>
            </template>
            <template #footer>
                <a :href="version.link" class="btn btn-primary" target="_blank">
                    <i class="fas fa-external-link-square-alt mr-1"></i> {{ __('View') }}
                </a>
            </template>
        </modal>
    </div>
</template>

<script>
export default {
    props: {
        version: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            open: false,
        }
    },

    mounted() {
        if (this.shouldShowNotification()) {
            this.notify();
        }
    },

    methods: {
        notify() {
            this.$toasted.info(this.__('New version :version available', {version: this.version.id}), {
                position: "bottom-right",
                action: [
                    {
                        text: this.__('View'),
                        onClick: (e, toastObject) => {
                            toastObject.goAway(0);
                            this.open = true;
                        }
                    },
                    {
                        text: this.__('Hide'),
                        onClick: (e, toastObject) => {
                            toastObject.goAway(0);
                            this.dismiss();
                        }
                    },
                ]
            });
        },

        dismiss() {
            localStorage.setItem('hideNotifierUntil', this.getTimestamp() + 600);
        },

        shouldShowNotification() {
            if (this.version === null || false === this.version.is_new) {
                return false;
            }

            let timestamp = localStorage.getItem('hideNotifierUntil') || null;

            if (timestamp && timestamp > this.getTimestamp()) {
                return false;
            }

            return true;
        },

        getTimestamp() {
            return Date.now() / 1000 | 0;
        },
    },

    computed: {
        hasNewVersion: function () {
            return this.version && this.version.is_new;
        }
    }
}
</script>
