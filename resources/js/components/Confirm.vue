<template>
    <component :is="tag" @click.stop.prevent="click">
        <span v-if="!clicked" v-html="text"></span>
        <span v-html="textConfirm" v-else></span>
    </component>
</template>

<script>
export default {
    props: {
        tag: {
            type: String,
            required: false,
            default: 'a',
        },
        text: {
            type: String,
            required: false,
            default: 'Click',
        },
        textConfirm: {
            type: String,
            required: false,
            default: 'Confirm',
        },
        duration: {
            type: Number,
            required: false,
            default: 500,
        },
        href: {
            type: String | null,
            required: false,
            default: null
        }
    },

    data() {
        return {
            clicked: false,
        }
    },

    methods: {
        click() {
            if (this.clicked) {
                return this.confirmed();
            }

            this.clicked = true;

            setTimeout(() => {
                this.clicked = false;
            }, this.duration);
        },

        confirmed() {
            if (this.href) {
                window.location = this.href;
            }

            this.$emit('confirmed');
        }
    }
}
</script>
