<template>
    <div>
        <div class="form-group">
            <select id="type" v-model="type" class="form-control custom-select">
                <option value="none">{{ __('None') }}</option>
                <option value="image">{{ __('Image') }}</option>
                <option value="gradient">{{ __('Gradient') }}</option>
            </select>
        </div>

        <div v-if="type === 'image'">
            <div class="row">
                <div class="col-12">
                    <div class="custom-file">
                        <label for="file" class="custom-file-label" :data-browse="__('Browse')">{{ __('File') }}</label>
                        <input type="file" class="custom-file-input" id="file" @change="handleFile" accept="image/*" :value="image.name"/>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="type === 'gradient'">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start">{{ __('Color #:number', {number: 1}) }}</label>
                        <input type="color" class="form-control" id="start" v-model="gradient.start">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="end">{{ __('Color #:number', {number: 2}) }}</label>
                        <input type="color" class="form-control" id="end" v-model="gradient.end">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="orientation">{{ __('Orientation') }}</label>
                        <input type="number" class="form-control" id="orientation" v-model="gradient.orientation" min="0" max="360" step="5">
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" :name="name" id="name" :value="data" />
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        },
        values: {
            type: Object,
            required: false,
            default: null
        }
    },

    data() {
        return {
            type: 'image',
            original: null,
            gradient: {
                start: null,
                end: null,
                orientation: 0,
            },
            image: {
                base64: null
            }
        }
    },

    mounted() {
        if (this.values) {
            this.type = this.values.type;

            if (this.type === 'gradient') {
                this.gradient.start = this.values.start || null;
                this.gradient.end = this.values.end || null;
                this.gradient.orientation = this.values.orientation || 90;
            }
        }

        this.original = $('body').css('background-image');
    },

    methods: {
        handleFile(event) {
            let file = event.target.files[0];
            let reader = new FileReader();

            if (false === file.type.match('image/*')) {
                return;
            }

            reader.onload = () => {
                this.image.base64 = reader.result;
            };

            reader.readAsDataURL(file);
        },

        setBackground() {
            if (this.type === 'none') {
                $('body').css('background-image', '');
            }

            if (this.type === 'image') {
                $('body').css({
                    'background-image': this.backgroundImage,
                    'background-size': 'cover',
                    'background-repeat': 'no-repeat',
                    'background-position': 'center center',
                });
            }

            if (this.type === 'gradient') {
                $('body').css('background-image', this.backgroundGradient);
            }
        }
    },

    computed: {
        backgroundGradient() {
            if (this.gradient.start && this.gradient.end) {
                return `linear-gradient(${this.gradient.orientation}deg, ${this.gradient.start} 0%, ${this.gradient.end} 100%)`;
            }

            return null;
        },

        backgroundImage() {
            if (this.image.base64) {
                return `url("${this.image.base64}")`;
            }

            return null;
        },

        data() {
            let data = JSON.stringify({
                type: 'none',
            });

            if (this.type === 'gradient' && this.backgroundGradient) {
                data = JSON.stringify({
                    type: 'gradient',
                    start: this.gradient.start,
                    end: this.gradient.end,
                    orientation: this.gradient.orientation,
                });
            }

            if (this.type === 'image' && this.backgroundImage) {
                data = JSON.stringify({
                    type: 'image',
                    base64: this.image.base64,
                })
            }

            return data;
        },
    },

    watch: {
        type: function (value) {
            this.setBackground();
        },

        backgroundImage: function (value) {
            this.setBackground();
        },

        backgroundGradient: function (value) {
            this.setBackground();
        }
    }
}
</script>
