@extends('layouts/master')

@section('content')

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
      <td>{{ $u->username }}</td>
      <td class="hidden-xs">{{ $u->email }}</td>
      <td>{{ $u->function }}</td>
      <td class="actions">
        <a role="button" title="Bewerken" class="user-edit btn btn-success btn-xs" href="{{ URL::to('users/edit/'.$u->id) }}">
          <span class="glyphicon glyphicon-pencil"></span>
        </a>
        <a {{ $u->id == Auth::user()->id ? '' : 'disabled' }} role="button" title="Wachtwoord wijzigen" class="user-edit-pw btn btn-primary btn-xs" href="#">
          <span class="glyphicon glyphicon-lock"></span>
        </a>
        <a role="button" title="Verwijderen" class="user-delete btn btn-danger btn-xs" href="{{ URL::to('users/delete/'.$u->id) }}" onclick="return confirm('Weet je het zeker?')">
          <span class="glyphicon glyphicon-remove"></span>
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

@stop