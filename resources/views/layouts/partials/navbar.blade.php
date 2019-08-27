<nav class="navbar navbar-expand-md navbar-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel Shaarli') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        @can('restricted')
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
                                <a class="dropdown-item" href="{{ route('chest.create') }}">{{ __('Add chest') }}</a>

                                <h6 class="dropdown-header">{{ __('Manage') }}</h6>

                                <a class="dropdown-item" href="{{ route('account') }}">{{ __('Compte') }}</a>
                                <a class="dropdown-item" href="{{ route('manage.tags') }}">{{ __('Données') }}</a>

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
        @endcan
    </div>
</nav>