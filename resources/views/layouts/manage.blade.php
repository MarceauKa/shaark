<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.head')
</head>
<body class="{{ app('shaarli')->getIsDark() ? 'dark' : 'light' }}">
    <div id="app">
        @include('layouts.partials.navbar')
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <div class="list-group">
                            <a href="{{ route('manage.settings') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/settings') ? ' active' : '' }}"
                            >{{ __('Settings') }}</a>
                            <a href="{{ route('manage.tags') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/tags') ? ' active' : '' }}"
                            >{{ __('Tags') }}</a>
                            <a href="{{ route('manage.logins') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/logins') ? ' active' : '' }}"
                            >{{ __('Logins') }}</a>
                            <a href="{{ route('manage.export') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/export') ? ' active' : '' }}"
                            >{{ __('Export') }}</a>
                            <a href="{{ route('manage.import') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/import') ? ' active' : '' }}"
                            >{{ __('Import') }}</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
        @include('layouts.partials.footer')
    </div>
    @include('layouts.partials.scripts')
</body>
</html>
