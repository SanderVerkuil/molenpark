<!-- Start external javascript files -->
{{ Bootstrap::js('local', ['type' => 'text/javascript']) }}
<script src="{{ asset("assets/js/jquery.growl.js") }}"></script>
@if (isset($javascripts))
  @if (is_array($javascripts))
    @foreach ($javascripts as $js)
      <script src="{{ asset("assets/js/$js.js") }}"></script>
    @endforeach
  @else
    <script src="{{ asset("assets/js/$javascripts.js") }}"></script>
  @endif
@endif

<script type="text/javascript">
  $(document).ready(function() {
    @if(Session::has('success'))
      $.growl.notice({message:"{{Session::get('success')}}"});
    @endif
    @if(Session::has('error'))
      $.growl.error({message:"{{Session::get('error')}}"});
    @endif
    @if(Session::has('info'))
      $.growl({message:"{{Session::get('info')}}"});
    @endif
  });
</script>
<!-- End external javascript files -->
