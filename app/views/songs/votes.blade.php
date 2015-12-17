@extends('layouts/master')

@section('content')

<style>
  .modal-dialog {
    overflow-y: initial !important
  }
  .modal-body {
    max-height: 80vh;
    overflow-y: auto;
  }
</style>

<h2>Emptor-pagina</h2>

<form action="" id="filter-form">
  <input type="checkbox" name="uitgestemd" value="1" id="include-voted-no" {{Input::get("uitgestemd") ? "checked" : ""}}>
  <label for="include-voted-no">Laat uitgestemde nummers zien</label>
</form>

<?php
  $statuses = Config::get('enum.songstatus');
  unset($statuses[0]);
?>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Nummer</th>
      <th>Status</th>
      <th>Bijgewerkt</th>
      <th>iTunes</th>
    </tr>
  </thead>
  <tbody>
  @foreach($songs as $s)
    <tr data-song-id="{{$s->id}}">
      <td>{{$s->artist}} - {{$s->title}}</td>
      <td>
        <select name="status" id="songStatus{{$s->id}}">
        @foreach($statuses as $st)
          <option value="{{$st}}" {{$st == $s->status ? 'selected' : ''}}>{{$st}}</option>
        @endforeach
        </select>
      </td>
      <td>{{$s->updated_at}}</td>
      <td><button class="btn-itunes btn btn-xs btn-primary" data-toggle="modal" data-target="#songModal{{$s->id}}">Zoeken</button>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

@foreach($songs as $s)

<div id="songModal{{$s->id}}" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Sluiten"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">{{$s->artist}} - {{$s->title}} <small>iTunes Store</small></h3>
      </div>

      <div class="modal-body">
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endforeach

@stop