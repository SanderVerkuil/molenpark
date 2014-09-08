@extends('layouts/master')

@section('style')
<style type="text/css">
  
</style>
@stop

@section('content')

  <div class="row">

    <div class="col-md-7">
      <form role="form">
        <div class="form-group">
          <label for="song-title">Titel</label>
          <input id="song-title" class="form-control" name="title">
        </div>
        <div class="form-group">
          <label for="song-artist">Artiest</label>
          <input id="song-artist" class="form-control" name="artist">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>

    <div id="video-finder" class="col-md-5">

    </div>

  </div>

@stop
