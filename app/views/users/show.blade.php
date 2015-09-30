@extends('layouts/master')

@section('content')

<h1>{{ $user->username }}</h1>
@if ($user->function)
<h2>{{ Config::get('enum.functions')[$user->function] }}</h2>
@endif
<p>{{ $user->email }}</p>

@stop