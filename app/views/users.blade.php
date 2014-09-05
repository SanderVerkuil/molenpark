@extends('layouts/master')

@section('content')
  <h1>Users</h1>
  @foreach($users as $user)
    <p>{{ $user->name }}</p>p>
  @endforeach
@stop
