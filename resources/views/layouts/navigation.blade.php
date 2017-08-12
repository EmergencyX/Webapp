@inject('navigation', 'EmergencyExplorer\Http\View\Helper\NavigationHelper')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseNav"
                aria-controls="collapseNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="{{ action('HomeController@index') }}">Emergency Explorer</a>

        <div class="collapse navbar-collapse" id="collapseNav">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 text-danger">
                {{--
                <li class="nav-item {{ $navigation->isProjects() }}">
                    <a class="nav-link" href="{{ action('Project\ProjectController@index') }}">{{ trans('app.modifications') }}</a>
                </li>
                <li class="nav-item {{ $navigation->isUsers() }}">
                    <a class="nav-link" href="{{ action('UserController@index') }}">{{ trans('app.users') }}</a>
                </li>
                --}}

                <li class="nav-item {{ $navigation->isMultiplayer() }}">
                    <a class="nav-link"
                       href="{{ action('Multiplayer\MultiplayerController@index', ['emergency-4']) }}">{{ trans('app.multiplayer') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="//fms.emergencyx.de">FMS</a>
                </li>
            </ul>
            {{--
            <ul class="my-2 my-lg-0">
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ $userUtil->url(auth()->user())  }}">Profil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="{{ action('Auth\LoginController@logout') }}">{{ trans('auth.logout') }}</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item {{ $navigation->isLogin() }}">
                        <a class="nav-link"
                           href="{{ action('Auth\LoginController@showLoginForm') }}">{{ trans('auth.join_the_force') }}</a>
                    </li>
                @endif
            </ul>
            --}}
        </div>
    </div>
</nav>