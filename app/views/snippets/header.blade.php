<script type="text/javascript">
  base_url = "{{ URL::to('/')}}/";
</script>
<title>
  @section('title')
  Dixocie
  @show
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- CSS are placed here -->
{{ Bootstrap::css('local', ['type' => 'text/css']) }}
<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/jquery.growl.css") }}">
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
  .help {
    cursor: help;
  }
</style>
@yield('styles')
