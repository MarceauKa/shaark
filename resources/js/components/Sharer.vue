<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ajout rapide</h5>

            <p class="card-text">
                Configurez votre bouton d'ajout rapide et faite le glisser dans votre barre de favoris.
            </p>

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" v-model="name" maxlength="40">
            </div>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="width">Largeur</label>
                        <input type="number" class="form-control" id="width" v-model="width">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="height">Hauteur</label>
                        <input type="number" class="form-control" id="height" v-model="height">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Bouton à mettre en favoris</label><br>
                <a class="btn btn-outline-primary" :href="script" v-text="name"></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        url: {
            type: String,
            required: true
        },
    },

    data() {
        return {
            name: 'Shaare',
            width: 600,
            height: 390,
        }
    },

    mounted() {
    },

    computed: {
        options() {
            return `menubar=no,height=${this.height},width=${this.width},toolbar=no,scrollbars=no,status=no,dialog=1`;
        },
        script() {
            return `javascript:(function(){var url=location.href; window.open('${this.url}?url=' + encodeURIComponent(url), '_blank', '${this.options}');})();`;
        }
    }
}
</script>
