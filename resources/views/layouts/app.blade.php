<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@if(isset($page_title)){{ $page_title }} - @endif{{ config('app.name') }}</title>
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
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light mb-3">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel Shaarli') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <search url="{{ route('api.search') }}" id="search"></search>

                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <h6 class="dropdown-header">{{ __('Contents') }}</h6>
                                    <a class="dropdown-item" href="{{ route('link.create') }}">{{ __('Add link') }}</a>
                                    <a class="dropdown-item" href="{{ route('story.create') }}">{{ __('Add story') }}</a>
                                    <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                                    <a class="dropdown-item" href="{{ route('account') }}">{{ __('Compte') }}</a>
                                    <a class="dropdown-item" href="{{ route('import') }}">{{ __('Import') }}</a>
                                    <h6 class="dropdown-header">{{ __('Session') }}</h6>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <p class="text-center">
                {{ config('app.name') }} -
                <a href="{{ route('feeds.main') }}">{{ __('RSS Feed') }}</a> -
                <a href="https://github.com/MarceauKa/laravel-shaarli">{{ __('Source code') }}</a>
            </p>
        </footer>

        @include('partials.flash')
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('js')
</body>
</html>
