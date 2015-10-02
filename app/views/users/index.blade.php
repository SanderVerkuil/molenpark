@extends('layouts/master')

@section('content')
<style>
  .actions form {
    display: inline;
  }
</style>

<h2>Ledenlijst</h2>

<table id="manage" class='table-striped table table-bordered table-hover'>
  <thead>
    <tr>
      <th class="hidden-xs hidden-sm">UID</th>
      <th>Gebruikersnaam</th>
      <th class="hidden-xs">E-mail</th>
      <th>Functie</th>
      <th>Acties</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($users as $u)
    <tr>
      <td class="hidden-xs hidden-sm">{{ $u->id }}</td>
      <td><a href="{{ URL::action('user.show', $u->id) }}">{{ $u->username }}</a></td>
      <td class="hidden-xs">{{ $u->email }}</td>
      <td>@if ($u->function){{ Config::get('enum.functions')[$u->function] }}@endif</td>
      <td class="actions">
        <a role="button" title="Bewerken" class="user-edit btn btn-success btn-xs" href="{{ URL::action('user.edit', $u->id) }}">
          <span class="glyphicon glyphicon-pencil"></span>
        </a>
        <a {{ $u->id == Auth::user()->id ? '' : 'disabled' }} role="button" title="Wachtwoord wijzigen" class="user-edit-pw btn btn-primary btn-xs" href="#">
          <span class="glyphicon glyphicon-lock"></span>
        </a>
        {{ Form::model($u, array('route' => array('user.destroy', $u->id), 'method' => 'DELETE')) }}
        <button title="Verwijderen" class="user-delete btn btn-danger btn-xs" onclick="return confirm('Weet je het zeker?')">
          <span class="glyphicon glyphicon-remove"></span>
        </button>
        {{ Form::close() }}
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

@stop