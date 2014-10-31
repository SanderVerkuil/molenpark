@extends('layouts/master')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <form role="form" method="get" id="search">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="artiest">Artiest</label>
            <div class="input-group">
              <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
              <input type="text" name="artiest" id="artiest" placeholder="Artiest" class="form-control song-search" />
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="title">Titel</label>
            <div class="input-group">
              <div class="input-group-addon"><span class="glyphicon glyphicon-music"></span></div>
              <input type="text" name="titel" id="title" placeholder="Titel" class="form-control song-search" />
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <button type="button" form="search" class="btn btn-primary btn-block">Zoeken</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="row" style="margin-top: 20px">
  <div class="col-sm-12">
    <div id="overview">
    </div>
  </div>
</div>
@stop

