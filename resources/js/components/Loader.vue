<template>
    <div class="d-flex align-content-center align-items-center" v-if="loading">
        <div class="spinner-grow mr-2" role="status"></div>
        <div>{{ __("Loading") }}</div>
    </div>
</template>

<script>
export default {
    props: {
        loading: {
            type: Boolean,
            required: false,
            default: false,
        }
    }
}
</script>
