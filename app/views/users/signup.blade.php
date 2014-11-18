@extends("layouts/basic")

@section('header')
  @include('snippets/header')
@endsection


@section("body")

  @include("snippets/navbar")
  @if(Session::has('success'))
        {{ Bootstrap::success(Session::get('success'), '', true) }}
      @endif
      @if(Session::has('error'))
        {{ Bootstrap::danger(Session::get('error'), '', true) }}
      @endif
      @if(Session::has('info'))
        {{ Bootstrap::danger(Session::get('info'), '', true) }}
      @endif


  <div class="users-container">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registreren</h4>
          </div>
          <div class="modal-body">
            {{ Form::open(array('url' => 'users/create')) }}
            {{ Bootstrap::vertical()->text('username', 'Gebruikersnaam', null, $errors) }}
            {{ Bootstrap::vertical()->email('email', 'Emailadres', '', $errors) }}
            {{ Bootstrap::vertical()->password('password', 'Wachtwoord', $errors) }}
            {{ Bootstrap::vertical()->password('password_confirmation', 'Wachtwoord bevestiging', $errors) }}
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
