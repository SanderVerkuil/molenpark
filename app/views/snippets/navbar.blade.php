<!-- Navbar -->
<div class="navbar navbar-inverse navbar-fixed-top{{Request::is('users/login') || Request::is('users/register') ? ' navbar-opaque' : ''}}" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href="{{ URL::to('') }}">DiscoCie</a>
    </div>
    <!-- Everything you want hidden at 940px or less, place within here -->
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('song/create') }}">Aanvragen</a></li>
        @if (Auth::check())
          @if (Auth::user()->canStartVoting())
          <li><a href="{{ URL::to('vote') }}">Stemmen</a></li>
          @endif
          @if (Auth::user()->canManageUsers())
          <li><a href="{{ URL::to('users/manage') }}">Leden</a></li>
          @endif
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::check())
          @include('layouts/loggedin')
        @else
          <li><a href="{{URL::to('users/login')}}">Inloggen</a></li>
        @endif
      </ul>
    </div>
  </div>
</div>
<!-- End Navbar -->
