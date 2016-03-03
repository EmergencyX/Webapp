<nav class="navbar navbar-light bg-faded">
  <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
    &#9776;
  </button>
  <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
    <a class="navbar-brand" href="{{ action('HomeController@index') }}">Emergency Explorer</a>
    <ul class="nav navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">{{ trans('app.modifications') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">{{ trans('app.multiplayer') }}</a>
      </li>
    </ul>
  </div>
</nav>