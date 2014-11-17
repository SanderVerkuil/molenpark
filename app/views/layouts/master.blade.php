@extends("layouts/basic")

@section('header')
  @include('snippets/header')
@endsection

@section('body')
  @include('snippets/navbar')

    <!-- Start of container -->
    <div class="container-fluid">

      @if(Session::has('success'))
        {{ Bootstrap::success(Session::get('success')) }}
      @endif
      @if(Session::has('error'))
        {{ Bootstrap::danger(Session::get('error')) }}
      @endif
      @if(Session::has('info'))
        {{ Bootstrap::danger(Session::get('info')) }}
      @endif

      <!-- Content -->
      @yield('content')
      <!-- End Content -->

    </div>
    <!-- End of container -->
@endsection

@section('javascripts')
  @include('snippets/javascripts')
@endsection
  
