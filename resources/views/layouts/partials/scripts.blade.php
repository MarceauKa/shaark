<script>
    var i18n = @json($lang);
    var user = @json(auth()->user());
</script>
<script src="{{ mix('js/manifest.js') }}" defer></script>
<script src="{{ mix('js/vendor.js') }}" defer></script>
<script src="{{ mix('js/app.js') }}" defer></script>
@if(app('shaark')->getAdditionalJs()){!! app('shaark')->getAdditionalJs() !!}@endif
@stack('js')
