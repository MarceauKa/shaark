<template>
    <label class="text-error" v-if="error">{{ error[0] }}</label>
</template>

<script>
export default {
    props: {
        error: {
            type: Object,
            required: true
        },
    },
}
</script>
