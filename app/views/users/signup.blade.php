@extends("layouts/basic")

@section('header')
  @include('snippets/header')
@endsection


@section("body")

  @include("snippets/navbar")
  <div class="users-container">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registreren</h4>
          </div>
          <div class="modal-body">
            {{ Form::open(array('url' => 'users/create')) }}
            {{ Bootstrap::vertical()->text('gebruikersnaam', 'Gebruikersnaam', null, $errors) }}
            {{ Bootstrap::vertical()->email('email', 'Emailadres', '', $errors) }}
            {{ Bootstrap::vertical()->password('wachtwoord', 'Wachtwoord', $errors) }}
            {{ Bootstrap::vertical()->password('wachtwoord_confirmation', 'Wachtwoord bevestiging', $errors) }}
          </div>
          <div class="modal-footer">
            {{ Bootstrap::vertical()->submit('Registreren') }}
            {{ Form::close() }}
          </div>
        </div>
      </div>

@endsection

@section('javascripts')
  @include('snippets/javascripts')
@endsection
