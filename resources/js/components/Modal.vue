<template>
    <div class="modal fade"
         :id="id"
         role="dialog"
         v-if="open"
    >
        <div class="modal-dialog modal-dialog-centered"
             :class="{'modal-lg': size === 'lg', 'modal-xl': size === 'xl', 'modal-sm': size === 'sm'}"
             role="document"
        >
            <div class="modal-content" :class="{'border-0': ! hasHeader && ! hasFooter}">
                <div class="modal-header" v-if="hasHeader">
                    <h5 class="modal-title"><slot name="header"></slot></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body" :class="{'p-0': ! hasHeader && ! hasFooter}">
                    <slot name="content"></slot>
                </div>

                <div class="modal-footer" v-if="hasFooter">
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
        size: {
            type: String,
            required: false,
            default: '',
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
                    this.deleteModal();
                });

                this.$emit('opened');
            });
        },

        deleteModal() {
            $(`#${this.id}`).modal('dispose');
            $('div.modal-backdrop').remove();
            $('body.modal-open').removeClass('modal-open');
            this.$emit('closed');
        },
    },

    watch: {
        open: function (value) {
            if (value === true) {
                this.createModal();
            } else {
                this.deleteModal();
            }
        },
    },

    computed: {
        hasHeader: function () {
            return this.$slots.hasOwnProperty('header');
        },

        hasFooter: function () {
            return this.$slots.hasOwnProperty('footer');
        },
    }
}
</script>
