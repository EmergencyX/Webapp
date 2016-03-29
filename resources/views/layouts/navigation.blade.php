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
                <li class="nav-item {{ isset($active) && $active === 'projects' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ action('ProjectController@index') }}">{{ trans('app.modifications') }}</a>
                </li>
                <li class="nav-item {{ isset($active) && $active === 'users' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ action('UserController@index') }}">{{ trans('app.users') }}</a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-xs-right">
                <li class="nav-item {{ isset($active) && $active === 'login' ? 'active' : '' }}">
                    @if(auth()->check())
                        <a class="nav-link" href="{{ action('Auth\AuthController@logout') }}">{{ trans('auth.logout') }}</a>
                    @else
                        <a class="nav-link" href="{{ action('Auth\AuthController@getLogin') }}">{{ trans('auth.join_the_force') }}</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
