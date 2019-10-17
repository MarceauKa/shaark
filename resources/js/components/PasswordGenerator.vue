<template>
    <button type="button" @click="generate"><i class="fas fa-dice"></i></button>
</template>

<script>
export default {
    props: {
        size: {
            type: Number,
            required: false,
            default: 16,
        },
        chars: {
            type: String,
            required: false,
        },
        original: {
            type: String,
            required: false,
            default: '',
        }
    },

    methods: {
        generate() {
            let length = this.alphabet().length;
            let password = '';

            while (password.length < this.size) {
                let random = Math.floor(Math.random() * length);
                password += this.alphabet()[random];
            }

            this.$emit('generated', password);
        },

        alphabet() {
            if (this.chars) {
                return this.chars;
            }

            return [
                'abcdefghijklmnopqrstuvwxyz',
                'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                '1234567890',
                '~!?@#$%&^_*+-=[]€,;:|()[]{}',
            ].join('');
        },
    },
}
</script>
