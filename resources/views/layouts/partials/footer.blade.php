<footer>
    <p class="text-center">
        {{ app('shaarli')->getName() }} - v{{ app('shaarli')::VERSION }} -
        <a href="{{ route('feeds.main') }}">{{ __('RSS Feed') }}</a> -
        <a href="https://github.com/MarceauKa/laravel-shaarli">{{ __('Source code') }}</a>
    </p>
</footer>

@include('partials.flash')