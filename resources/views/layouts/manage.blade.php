<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.head')
</head>
<body class="{{ app('shaark')->getIsDark() ? 'dark' : 'light' }}">
    <div id="app">
        @include('layouts.partials.navbar')
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <div class="list-group">
                            <a href="{{ route('manage.settings') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/settings') ? ' active' : '' }}"
                            ><i class="fas fa-fw fa-cogs mr-1"></i> {{ __('Settings') }}
                            </a>
                            <a href="{{ route('manage.tags') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/tags') ? ' active' : '' }}"
                            ><i class="fas fa-fw fa-tags mr-1"></i> {{ __('Tags') }}</a>
                            <a href="{{ route('manage.archives') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/archives') ? ' active' : '' }}"
                            ><i class="fas fa-fw fa-archive mr-1"></i> {{ __('Archives') }}</a>
                            <a href="{{ route('manage.users') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/users') ? ' active' : '' }}"
                            ><i class="fas fa-fw fa-users mr-1"></i> {{ __('Users') }}</a>
                            <a href="{{ route('manage.export') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/export') ? ' active' : '' }}"
                            ><i class="fas fa-fw fa-cloud-download-alt mr-1"></i> {{ __('Export') }}</a>
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
