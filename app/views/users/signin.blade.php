@extends('layouts/basic')

@section('header')
  @include('snippets/header')
@endsection

@section('body')
  <div class="background"></div>
  @include('snippets/navbar')

  <div class="users-container">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Inloggen</h4>
          </div>
          <div class="modal-body">
            {{ Form::open(array('url' => 'users/login')) }}
            {{ Bootstrap::vertical()->text('gebruikersnaam', 'Gebruikersnaam') }}
            {{ Bootstrap::vertical()->password('wachtwoord', 'Wachtwoord') }}
            <p class="text-right">
              <a href="{{ URL::to('users/register') }}">Nog geen account?</a>
            </p>
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
