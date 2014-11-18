@extends("layouts/basic")

@section('header')
  @include('snippets/header')
@endsection

@section('body')
  @include('snippets/navbar')

    <!-- Start of container -->
    <div class="container-fluid">

      @if(Session::has('success'))
        {{ Bootstrap::success(Session::get('success'), '', true) }}
      @endif
      @if(Session::has('error'))
        {{ Bootstrap::danger(Session::get('error'), '', true) }}
      @endif
      @if(Session::has('info'))
        {{ Bootstrap::danger(Session::get('info'), '', true) }}
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
  
