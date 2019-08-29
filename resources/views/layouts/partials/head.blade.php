<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@if(isset($page_title)){{ $page_title }} - @endif{{ app('shaarli')->getName() }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@if(auth()->check())
    <meta name="api-token" content="{{ auth()->user()->api_token }}">
@endif
@stack('meta')
@include('feed::links')
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
@stack('css')