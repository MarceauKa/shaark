<template>
    <div v-show="count > 0">
        <span class="items">
            <slot></slot>
        </span>
        <button type="button" class="btn btn-outline-secondary btn-sm mb-1" @click="show" v-if="count > limit && false === more">
            <i class="fas fa-plus"></i> {{ count - limit }}
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm mb-1" @click="hide" v-if="count > limit && true === more">
            <i class="fas fa-minus"></i>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        limit: {
            type: Number,
            required: false,
            default: 10
        },
        selector: {
            type: String,
            required: false,
            default: 'a'
        }
    },

    data() {
        return {
            items: null,
            count: 0,
            more: false,
        }
    },

    mounted() {
        this.items = $(`.items > ${this.selector}`);
        this.count = this.items.length;
        this.hide();
    },

    methods: {
        show() {
            this.more = true;

            this.items.each((index) => {
                let pos = index + 1;
                if (pos > this.limit) {
                    $(this.items[index]).removeClass('d-none');
                }
            })
        },

        hide() {
            this.more = false;

            this.items.each((index) => {
                let pos = index + 1;
                if (pos > this.limit) {
                    $(this.items[index]).addClass('d-none');
                }
            })
        }
    }
}
</script>
