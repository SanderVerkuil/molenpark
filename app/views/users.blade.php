@extends('layouts/master')

@section('content')
  <h1>Users</h1>
  @foreach($users as $user)
    <p>{{ $user->username }}</p>
  @endforeach
@stop
