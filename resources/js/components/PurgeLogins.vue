<template>
    <confirm :text="__('Purge')" :text-confirm="__('Confirm')" @confirmed="purge">

    </confirm>
</template>

<script>
export default {
    props: {
        endpoint: {
            type: String,
            required: true,
        }
    },

    methods: {
        purge() {
            axios.post(this.endpoint)
                .then(response => {
                    this.$toasted.success(this.__("Logins history has been purged"));
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                    this.$toasted.error(this.__("Unable to purge logins history"));
                })
        }
    }
}
</script>
