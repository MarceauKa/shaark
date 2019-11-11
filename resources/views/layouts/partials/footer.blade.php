<footer>
    <p class="text-center mb-0">
        {{ app('shaarli')->getName() }}
        &mdash; v{{ app('shaarli')::VERSION }}
        &mdash; <a href="https://github.com/MarceauKa/laravel-shaarli" target="_blank">{{ __('Source code') }}</a>
        @can('restricted')
            &mdash; <a href="{{ route('feed', 'rss') }}">{{ __('RSS Feed') }}</a>
            &mdash; <a href="{{ route('feed', 'atom') }}">{{ __('Atom Feed') }}</a>
        @endCan
    </p>
</footer>

@if(auth()->check())
    <temp-sharing dusk="temp-sharing"></temp-sharing>
@endif
@include('partials.flash')
