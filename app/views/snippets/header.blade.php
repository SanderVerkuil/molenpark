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
<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/min/jquery.css") }}">
@if (isset($css))
@if (is_array($css))
@foreach ($css as $c)
<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/min/$c.css") }}">
@endforeach
@else
<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/min/$css.css") }}">
@endif
@endif
<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/min/application.css") }}">
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
  .footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 40px;
    background-color: #f5f5f5;
  }
  .footer div {
    width: auto;
    text-align: center;
  }
  .footer p {
    margin: 10px 0;
  }
</style>
@yield('styles')
