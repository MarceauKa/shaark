<template>
    <div>
        <section v-if="!preview" ref="form">
            <draggable v-model="lines"
                       group="lines"
                       v-bind="dragOptions"
                       @start="drag=true"
                       @end="drag=false"
                       handle=".handle-order"
            >
                <transition-group
                        type="transition"
                        tag="div"
                        :name="!drag ? 'flip-list' : null"
                >
                    <div class="form-group"
                         v-for="(item, key) in lines"
                         :key="`item-${key}`"
                    >
                        <div class="row row-line">
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        >{{ types[item.type] }}</button>

                                        <div class="dropdown-menu">
                                            <a v-for="(type, key) in types"
                                               class="dropdown-item"
                                               :class="{'active': key === item.type}"
                                               @click.prevent="item.type = key"
                                            >{{ type }}</a>
                                        </div>
                                    </div>

                                    <input type="text" class="form-control" name="name" v-model="item.name" :placeholder="__('Name')" />
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="input-group">
                                    <textarea class="form-control" rows="5" name="value" v-model="item.value" v-if="item.type === 'code'"></textarea>
                                    <input type="text" class="form-control" name="value" v-model="item.value" autocomplete="off" v-else>

                                    <div class="input-group-append">
                                        <password-generator v-if="item.type === 'password'"
                                                            :original="item.value"
                                                            @generated="setPassword($event, item)"
                                        ></password-generator>
                                        <confirm tag="button"
                                                 class="btn btn-outline-secondary"
                                                 @confirmed="deleteLine(item)"
                                                 text="<i class='fas fa-trash-alt'></i>"
                                                 text-confirm="<i class='fas fa-check'></i>"
                                        ></confirm>
                                        <button class="btn btn-outline-secondary handle-order" type="button"><i class="fas fa-arrows-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </draggable>

            <div class="form-group text-right">
                <button type="button" v-for="(type, key) in types"
                        class="btn btn-outline-secondary mr-1"
                        @click.prevent="addLine(key)"
                >{{ __('Add') }} {{ type }}</button>
            </div>
        </section>

        <section class="my-3" ref="preview" v-else>
            <div class="row mb-3" v-for="(line, key) in preview">
                <div class="col-12">
                    <strong>{{ line.name }}</strong>
                </div>

                <div class="col-12">
                    <a :href="line.value" target="_blank" v-if="line.type === 'url'">{{ line.value }}</a>

                    <div class="input-group input-group-sm" v-else-if="line.type === 'password'">
                        <input type="password" class="form-control" autocomplete="off" :value="line.value" readonly>

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary"
                                    type="button"
                                    @click="toggleShowPassword($event, key)"
                            >{{ __('Show') }}</button>
                            <button class="btn btn-outline-secondary"
                                    type="button"
                                    @click="copyToClipboard($event, line.value)"
                            >{{ __('Copy') }}</button>
                        </div>
                    </div>

                    <pre class="border p-2" v-else-if="line.type === 'code'"><code>{{ line.value }}</code></pre>

                    <span v-else>{{ line.value }}</span>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
let defaultLine = function () {
    return {
        type: 'text',
        name: '',
        value: '',
    }
};

export default {
    props: {
        preview: {
            type: Object|null,
            required: false,
            default: null
        }
    },

    data() {
        return {
            lines: [],
            types: {
                'url': this.__('URL'),
                'text': this.__('Text'),
                'password': this.__('Secret'),
                'code': this.__('Code'),
            },
            line: defaultLine(),
            drag: false,
            dragOptions: {
                animation: 200,
                group: "lines",
                disabled: false,
                ghostClass: "ghost",
                forceFallback: true
            },
        }
    },

    methods: {
        addLine(type) {
            this.line.type = type;
            this.lines.push(this.line);
            this.line = defaultLine();

            this.$nextTick(() => {
                let inputs = this.$refs.form.querySelectorAll('.row-line input[name="value"]');
                inputs[inputs.length - 1].focus();
            });
        },

        deleteLine(line) {
            this.lines.splice(this.lines.indexOf(line), 1);
        },

        copyToClipboard($event, value) {
            let original = $event.target.innerHTML;
            $event.target.innerHTML = this.__('Copied');

            let timeout = setTimeout(() => {
                $event.target.innerHTML = original;
            }, 1000);

            const el = document.createElement('textarea');
            let storeContentEditable = el.contentEditable;
            let storeReadOnly = el.readOnly;

            el.value = value;
            el.contentEditable = true;
            el.readOnly = false;
            el.setAttribute('readonly', false); // Make it readonly false for iOS compatability
            el.setAttribute('contenteditable', true); // Make it editable for iOS
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);

            const selected = document.getSelection().rangeCount > 0 ? document.getSelection().getRangeAt(0) : false;

            el.select();
            el.setSelectionRange(0, 999999);
            document.execCommand('copy');
            document.body.removeChild(el);

            if (selected) {
                document.getSelection().removeAllRanges();
                document.getSelection().addRange(selected);
            }

            el.contentEditable = storeContentEditable;
            el.readOnly = storeReadOnly;
        },

        toggleShowPassword($event, key) {
            const el = $event.target.parentNode.parentNode.firstChild;
            el.type = el.type === 'password' ? 'text' : 'password';
            $event.target.innerHTML = el.type === 'password' ? this.__('Show') : this.__('Hide');
        },

        setPassword($event, item) {
            item.value = $event;
        }
    },

    watch: {
        '$attrs.value': function (value) {
            this.lines = value;
        },

        lines: function (value) {
            this.$emit('input', value);
        }
    }
}
</script>

<style>
    .flip-list-move {
        transition: transform 0.5s;
    }
    .no-move {
        transition: transform 0s;
    }
    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }
</style>
