@inject('navigation', 'EmergencyExplorer\Http\View\Helper\NavigationHelper')

<nav class="navbar navbar-static-top navbar-light bg-faded p-x-0">
    <div class="container">
        <a class="navbar-brand hidden-sm-up" href="{{ action('HomeController@index') }}">Emergency Explorer</a>
        <button class="navbar-toggler hidden-sm-up pull-right" type="button" data-toggle="collapse" data-target="#collapseNav">
            &#9776;
        </button>
        <div class="clearfix"></div>
        <div class="collapse navbar-toggleable-xs" id="collapseNav">
            <a class="navbar-brand hidden-xs-down" href="{{ action('HomeController@index') }}">Emergency Explorer</a>
            <ul class="nav navbar-nav">
                <li class="nav-item {{ $navigation->isProjects() }}">
                    <a class="nav-link" href="{{ action('ProjectController@index') }}">{{ trans('app.modifications') }}</a>
                </li>
                <li class="nav-item {{ $navigation->isUsers() }}">
                    <a class="nav-link" href="{{ action('UserController@index') }}">{{ trans('app.users') }}</a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-xs-right">
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ \EmergencyExplorer\Util\UserUtil::getUserAction(auth()->user()) }}">Profil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ action('Auth\AuthController@logout') }}">{{ trans('auth.logout') }}</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item {{ $navigation->isLogin() }}">
                        <a class="nav-link" href="{{ action('Auth\AuthController@getLogin') }}">{{ trans('auth.join_the_force') }}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
