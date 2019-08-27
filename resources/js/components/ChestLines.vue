<template>
    <div>
        <section class="border p-3" v-if="!preview">
            <div class="form-group" v-for="item in lines">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ types[item.type] }}</span>
                            </div>

                            <input type="text" class="form-control" v-model="item.name" placeholder="Nom" />
                        </div>
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="input-group">
                            <textarea class="form-control" rows="5" v-model="item.value" v-if="item.type === 'code'"></textarea>
                            <input type="text" class="form-control" v-model="item.value" v-else>

                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" @click.prevent="deleteLine(item)">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                >{{ types[line.type] }}</button>

                                <div class="dropdown-menu">
                                    <a v-for="(type, key) in types" class="dropdown-item" :class="{'active': key === line.type}" @click.prevent="setLineType(key)">{{ type }}</a>
                                </div>
                            </div>

                            <input type="text" id="name" class="form-control" v-model="line.name" placeholder="Nom" />
                        </div>
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="input-group">
                            <textarea class="form-control" rows="5" v-model="line.value" placeholder="Contenu" v-if="line.type === 'code'"></textarea>
                            <input type="text" class="form-control" v-model="line.value" placeholder="Contenu" @keydown.enter="addLine" v-else>

                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" @click.prevent="addLine">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="my-3" v-else>
            <div class="row mb-3" v-for="(line, key) in preview">
                <div class="col-12">
                    <strong>{{ line.name }}</strong>
                </div>

                <div class="col-12">
                    <a :href="line.value" target="_blank" v-if="line.type === 'url'">{{ line.value }}</a>

                    <div class="input-group input-group-sm" v-else-if="line.type === 'password'">
                        <input type="password" class="form-control" :id="`input-${key}`" :value="line.value">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" @click="toggleShowPassword($event, key)">Afficher</button>
                            <button class="btn btn-outline-secondary" type="button" @click="copyToClipboard($event, line.value)">Copier</button>
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
                'url': 'URL',
                'text': 'Texte',
                'password': 'Secret',
                'code': 'Code',
            },
            line: defaultLine(),
        }
    },

    mounted() {
    },

    methods: {
        addLine() {
            this.lines.push(this.line);
            this.line = defaultLine();
        },

        deleteLine(line) {
            this.lines.splice(this.lines.indexOf(line), 1);
        },

        setLineType(type) {
            this.line.type = type;

            if (this.line.name.length === 0) {
                this.line.name = this.types[this.line.type];
            }
        },

        copyToClipboard($event, value) {
            let original = $event.target.innerHTML;
            $event.target.innerHTML = 'Copié !';

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
            const el = document.getElementById(`input-${key}`);
            el.type = el.type === 'password' ? 'text' : 'password';
            $event.target.innerHTML = el.type === 'password' ? 'Afficher' : 'Cacher';
        },
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

</style>
