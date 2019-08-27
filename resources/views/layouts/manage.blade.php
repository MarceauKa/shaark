<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.head')
</head>
<body>
    <div id="app">
        @include('layouts.partials.navbar')
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="list-group">
                            <a href="{{ route('manage.import') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/import') ? ' active' : '' }}"
                            >{{ __('Import') }}</a>
                            <a href="{{ route('manage.tags') }}"
                               class="list-group-item list-group-item-action{{ request()->is('manage/tags') ? ' active' : '' }}"
                            >{{ __('Tags') }}</a>
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
