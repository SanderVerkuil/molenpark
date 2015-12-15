@extends('layouts/master')

@section('content')

@if ($user)
<h1>{{ $user->username }}</h1>
@if ($user->function)
<h2>{{ Config::get('enum.functions')[$user->function] }}</h2>
@endif
<p>{{ $user->email }}</p>
@endif

@stop