@extends('layouts/basic')

@section('header')
  @include('snippets/header')
@endsection

@section('body')
  @include('snippets/navbar')

  <div class="users-container">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Inloggen</h4>
          </div>
          <div class="modal-body">
            {{ Form::open(array('url' => 'users/login')) }}
            {{ Bootstrap::vertical()->text('username', 'Gebruikersnaam') }}
            {{ Bootstrap::vertical()->password('password', 'Wachtwoord') }}
          </div>
          <div class="modal-footer">
            {{ Bootstrap::vertical()->submit('Inloggen') }}
            {{ Form::close() }}
          </div>
        </div>
      </div>
  </div>
@endsection

@section('javascripts')
  @include('snippets/javascripts')
@endsection
