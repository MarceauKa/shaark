<template>
    <div></div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: false,
            default: 'success',
        }
    },

    mounted() {
        if (this.message.length > 0) {
            this.$toasted.show(this.message, {
                type: this.type
            });
        }
    },
}
</script>
