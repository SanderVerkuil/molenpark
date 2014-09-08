@extends('layouts/master')

@section('content')
  <form role="form" action="" method="get">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="artiest">Artiest</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
          <input type="text" name="artiest" id="artiest" placeholder="Artiest" class="form-control" />
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="title">Titel</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-music"></span></div>
          <input type="text" name="titel" id="title" placeholder="Titel" class="form-control" />
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      <button type="button" class="btn btn-primary btn-block">Search</button>
    </div>
  </form>
@stop

