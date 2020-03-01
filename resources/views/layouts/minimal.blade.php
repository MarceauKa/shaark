<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.head')
</head>
<body class="{{ app('shaark')->getIsDark() ? 'dark' : 'light' }}">
    <div id="app">
        <main class="d-flex py-auto align-items-center">
            @yield('content')
        </main>
    </div>
    @include('layouts.partials.scripts')
</body>
</html>
