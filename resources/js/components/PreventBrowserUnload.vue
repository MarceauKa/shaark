<script>
export default {
    props: {
        prevent: {
            type: Boolean,
            required: false,
            default: true
        }
    },

    mounted() {
        window.addEventListener('beforeunload', (event) => {
            if (this.prevent === true) {
                event.stopPropagation();
                event.preventDefault();
                event.returnValue = '';
            }
        });
    },
}
</script>
