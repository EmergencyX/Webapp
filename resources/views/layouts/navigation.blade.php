<nav class="navbar navbar-light bg-faded">
  <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
    &#9776;
  </button>
  <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
    <a class="navbar-brand" href="{{ action('HomeController@index') }}">Emergency Explorer</a>
    <ul class="nav navbar-nav">
      <li class="nav-item {{ isset($active) && $active === 'projects' ? 'active' : '' }}">
        <a class="nav-link" href="{{ action('ProjectController@index') }}">{{ trans('app.modifications') }}</a>
      </li>
    </ul>
    <ul class="nav navbar-nav pull-xs-right">
      <li class="nav-item {{ isset($active) && $active === 'login' ? 'active' : '' }}">
        @if(auth()->check())
            <a class="nav-link" href="{{ action('Auth\AuthController@getLogout') }}">{{ trans('auth.logout') }}</a>
        @else
            <a class="nav-link" href="{{ action('Auth\AuthController@getLogin') }}">{{ trans('auth.join_the_force') }}</a>
        @endif
      </li>
    </ul>
  </div>
</nav>