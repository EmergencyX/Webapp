<nav class="navbar navbar-static-top navbar-light bg-faded">
    <a class="navbar-brand hidden-sm-up pull-right" href="{{ action('HomeController@index') }}">Emergency Explorer</a>
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapeNav">
        &#9776;
    </button>
    <div class="container collapse navbar-toggleable-xs" id="collapeNav">
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
</nav>