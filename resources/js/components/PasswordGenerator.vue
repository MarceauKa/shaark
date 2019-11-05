<template>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-secondary border-right-0 dropdown-toggle"
                style="border-radius: 0"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            <i class="fas fa-dice pr-1"></i>
        </button>

        <div class="dropdown-menu">
            <h6 class="dropdown-header">{{ __('Alpha numeric with symbols') }}</h6>

            <button class="dropdown-item" @click="generate(8)">{{ __(':size chars', {size: 8}) }}</button>
            <button class="dropdown-item" @click="generate(16)">{{ __(':size chars', {size: 16}) }}</button>
            <button class="dropdown-item" @click="generate(24)">{{ __(':size chars', {size: 24}) }}</button>

            <h6 class="dropdown-header">{{ __('Alpha numeric only') }}</h6>

            <button class="dropdown-item" @click="generate(8, false)">{{ __(':size chars', {size: 8}) }}</button>
            <button class="dropdown-item" @click="generate(16, false)">{{ __(':size chars', {size: 16}) }}</button>
            <button class="dropdown-item" @click="generate(24, false)">{{ __(':size chars', {size: 24}) }}</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        original: {
            type: String,
            required: false,
            default: '',
        }
    },

    methods: {
        generate(size = 16, symbols = true) {
            let alphabet = this.alphabet(symbols);
            let length = alphabet.length;
            let password = '';

            while (password.length < size) {
                let random = Math.floor(Math.random() * length);
                password += alphabet[random];
            }

            this.$emit('generated', password);
        },

        alphabet(symbols = true) {
            return [
                'abcdefghijklmnopqrstuvwxyz',
                'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                '1234567890',
                '~!?@#$%&^_*+-=[]€,;:|()[]{}',
            ].slice(0, symbols ? 4 : 3).join('');
        },
    },
}
</script>
