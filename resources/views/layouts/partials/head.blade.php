<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@if(isset($page_title)){{ $page_title }} - @endif{{ app('shaarli')->getName() }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@if(auth()->check())
    <meta name="api-token" content="{{ auth()->user()->api_token }}">
@endif
@can('restricted')
<link rel="alternate" type="application/atom+xml" href="{{ route('feed', 'atom') }}" title="{{ __('ATOM Feed') }}" />
<link rel="alternate" type="application/rss+xml" href="{{ route('feed', 'rss') }}" title="{{ __('RSS Feed') }}" />
@endCan
@stack('meta')
<link rel="manifest" href="{{ route('pwa.manifest') }}">
<base href="{{ url()->route('home') }}">
<link rel="icon" type="image/png" href="{{ app('shaarli')->getCustomIconUrl() }}">
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
@stack('css')
@if(app('shaarli')->getCustomBackgroundCss())
<style>
    body,
    body.dark {
        background-image: {!! app('shaarli')->getCustomBackgroundCss() !!};
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
    }
</style>
@endif
