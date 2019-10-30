<script>
    var i18n = @json($lang);
</script>
<script src="{{ mix('js/manifest.js') }}" defer></script>
<script src="{{ mix('js/vendor.js') }}" defer></script>
<script src="{{ mix('js/app.js') }}" defer></script>
@stack('js')
<script>
if ("serviceWorker" in navigator) {
    if (navigator.serviceWorker.controller) {
        console.log("Running in PWA");
    } else {
        navigator
            .serviceWorker
            .register("sw.js", {scope: "./"})
            .then(function (reg) {
                console.log("PWA registered in " + reg.scope);
            });
    }
}
</script>
