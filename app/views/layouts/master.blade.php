<!DOCTYPE html>
<html>
  <head>
    <title>
      @section('title')
      Dixocie
      @show
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSS are placed here -->
    {{ Bootstrap::css() }}
    @if (isset($css))
      @if (is_array($css))
        @foreach ($css as $c)
          <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/$c.css") }}">
        @endforeach
      @else
        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/$css.css") }}">
      @endif
    @endif
    <!-- End CSS -->

    <style>
      body {
        padding-top: 60px;
      }
      .modal {
        overflow-y: auto;
      }
    </style>
    @yield('styles')

    <!-- Scripts are placed here -->
    {{ Bootstrap::js() }}
    <!-- End JS -->
  </head>

  <body>
    <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="#">Molenpark</a>
        </div>
        <!-- Everything you want hidden at 940px or less, place within here -->
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="{{{ URL::to('') }}}">Home</a></li>
            <li><a href="{{{ URL::to('song/create') }}}">Aanvragen</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Navbar -->

    <!-- Content -->
    @yield('content')
    <!-- End Content -->

    <!-- Start external javascript files -->
    @if (isset($javascripts))
      @if (is_array($javascripts))
        @foreach ($javascripts as $js)
           <script src="{{ asset("assets/js/$js.js") }}"></script>
        @endforeach
      @else
        <script src="{{ asset("assets/js/$javascripts.js") }}"></script>
      @endif
    @endif
    <!-- End external javascript files -->

  </body>
</html>