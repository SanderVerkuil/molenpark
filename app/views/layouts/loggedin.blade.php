<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ingelogd als {{{ Auth::user()->username }}} <span class="caret"></span></a>
  <ul class="dropdown-menu" role="menu">
    <li><a href="{{ URL::action('user.edit', Auth::user()->id) }}">Profiel bewerken</a></li>
    <li><a href="{{ URL::to('users/logout') }}">Uitloggen</a></li>
  </ul>
</li>