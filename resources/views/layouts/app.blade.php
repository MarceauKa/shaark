<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.head')
</head>
<body>
    <div id="app">
        @include('layouts.partials.navbar')
        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.partials.footer')
    </div>
    @include('layouts.partials.scripts')
</body>
</html>
