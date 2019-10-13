<footer>
    <p class="text-center mb-0">
        {{ app('shaarli')->getName() }} - v{{ app('shaarli')::VERSION }} -
        <a href="https://github.com/MarceauKa/laravel-shaarli">{{ __('Source code') }}</a>
    </p>
</footer>

@include('partials.flash')
