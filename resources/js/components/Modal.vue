<template>
    <div class="modal fade"
         :id="id"
         tabindex="-1"
         role="dialog"
         v-if="show"
    >
        <div class="modal-dialog modal-dialog-centered"
             :class="{'modal-lg': size === 'lg', 'modal-xl': size === 'xl', 'modal-sm': size === 'sm'}"
             role="document"
        >
            <div class="modal-content" :class="{'border-0': ! header && ! footer}">
                <div class="modal-header" v-if="header">
                    <h5 slot="header" class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" :class="{'p-0': ! header && ! footer}">
                    <slot name="content"></slot>
                </div>

                <div class="modal-footer" v-if="footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        open: {
            type: Boolean,
            required: false,
            default: false,
        },
        id: {
            type: String,
            required: false,
            default: 'modal',
        },
        header: {
            type: Boolean,
            required: false,
            default: false,
        },
        footer: {
            type: Boolean,
            required: false,
            default: false,
        },
        size: {
            type: String,
            required: false,
            default: '',
        }
    },

    data() {
        return {
            show: false,
        }
    },

    methods: {
        createModal() {
            this.$nextTick(() => {
                let modal = $(`#${this.id}`);

                modal.modal({
                    keyboard: false,
                    show: true
                });

                modal.on('hidden.bs.modal', (e) => {
                    this.show = false;
                    this.deleteModal();
                });

                this.$emit('opened');
            });
        },

        deleteModal() {
            $(`#${this.id}`).modal('dispose');
            this.$emit('closed');
        },
    },

    watch: {
        open: function (value) {
            this.show = value;
        },

        show: function (value) {
            if (value === true) {
                this.createModal();
            } else {
                this.deleteModal();
            }
        }
    }
}
</script>
