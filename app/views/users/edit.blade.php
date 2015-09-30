@extends('layouts/master')

@section('content')

{{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }}

{{ Bootstrap::vertical()->text('username', 'Gebruikersnaam', null, $errors) }}

@if (Auth::user()->canManageUsers())
{{ Bootstrap::vertical()->select('function', 'Functie', Config::get('enum.functions'), null, $errors) }}
@endif

{{ Bootstrap::vertical()->submit('Opslaan') }}

{{ Form::close() }}

@stop