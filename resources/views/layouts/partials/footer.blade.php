<footer>
    <p class="text-center mb-0">
        {{ app('shaark')->getName() }}
        &mdash; v{{ app('shaark')::VERSION }}
        &mdash; <a href="https://github.com/MarceauKa/shaark" target="_blank">{{ __('Source code') }}</a>
        @can('restricted')
            &mdash; <a href="{{ route('feed', 'rss') }}">{{ __('RSS Feed') }}</a>
            &mdash; <a href="{{ route('feed', 'atom') }}">{{ __('Atom Feed') }}</a>
        @endCan
    </p>
</footer>

<div id="network" :class="{'offline': !online}">
    <i class="fa fa-wifi mr-1"></i> {{ __('Network is offline') }}
</div>

@if(auth()->check())
    <temp-sharing dusk="temp-sharing"></temp-sharing>
    @if($version)
    <update-notifier dusk="update-notifier" :version="{{ $version }}"></update-notifier>
    @endif
@endif
@include('partials.flash')
