<footer>
    <p class="text-center">
        {{ config('app.name') }} -
        <a href="{{ route('feeds.main') }}">{{ __('RSS Feed') }}</a> -
        <a href="https://github.com/MarceauKa/laravel-shaarli">{{ __('Source code') }}</a>
    </p>
</footer>

@include('partials.flash')