<nav class="navbar navbar-expand-md navbar-light mb-3" id="nav">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ app('shaark')->getCustomIconUrl() }}">
            <span class="d-none d-md-inline">{{ app('shaark')->getName() }}</span>
        </a>

        @can('restricted')
            <search url="{{ route('api.search') }}" id="search"></search>
        @endcan

        <ul class="navbar-nav">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <span class="d-none d-md-block">{{ __('Login') }}</span>
                    <span class="d-block d-md-none"><i class="fas fa-user"></i></span>
                </a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }} <i class="fas fa-caret-down"></i></span>
                    <span class="d-inline d-md-none"><i class="fas fa-bars"></i></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <h6 class="dropdown-header">{{ __('Contents') }}</h6>

                    <a class="dropdown-item" href="{{ route('link.create') }}">
                        <i class="fas fa-link fa-fw mr-1"></i> {{ __('Add link') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('story.create') }}">
                        <i class="fas fa-book fa-fw mr-1"></i> {{ __('Add story') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('chest.create') }}">
                        <i class="fas fa-briefcase fa-fw mr-1"></i> {{ __('Add chest') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('album.create') }}">
                        <i class="fas fa-images fa-fw mr-1"></i> {{ __('Add album') }}
                    </a>

                    <h6 class="dropdown-header">{{ __('Manage') }}</h6>

                    <a class="dropdown-item" href="{{ route('account') }}">
                        <i class="fas fa-user fa-fw mr-1"></i> {{ __('Account') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('manage.settings') }}">
                        <i class="fas fa-cogs fa-fw mr-1"></i> {{ __('Settings') }}
                    </a>

                    <h6 class="dropdown-header">{{ __('Session') }}</h6>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-fw mr-1"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
        </ul>
    </div>
</nav>
