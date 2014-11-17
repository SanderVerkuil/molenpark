<!-- Start external javascript files -->
{{ Bootstrap::js('local', ['type' => 'text/javascript']) }}
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
