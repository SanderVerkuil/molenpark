@extends("layouts/basic")

@section('header')
  @include('snippets/header')
@endsection

@section('body')
  @include('snippets/navbar')

    <!-- Start of container -->
    <div class="container-fluid">

      <!-- Content -->
      @yield('content')
      <!-- End Content -->

    </div>
    <!-- End of container -->
@endsection

@section('javascripts')
  @include('snippets/javascripts')
@endsection
  
