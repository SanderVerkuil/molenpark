<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ingelogd als {{{ Auth::user()->username }}} <span class="caret"></span></a>
  <ul class="dropdown-menu" role="menu">
    @if (Auth::user()->canStartVoting())
      <li><a href="#">Start stemming</a></li>
    @endif
    <li><a href="{{ URL::to('users/logout') }}">Uitloggen</a></li>

  </ul>
