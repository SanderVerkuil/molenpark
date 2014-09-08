@extends('layouts/master')

@section('styles')
<link rel=stylesheet href="{{ asset('assets/css/video-finder.css'); }}">
<style type="text/css">
</style>
@stop

@section('content')
  <div class="row">
    <div class="col-sm-5 youtube-search">
      <form role="form">
        <div class="form-group">
          <label for="song-title">Titel</label>
          <input id="song-title" class="form-control song-info" name="title">
        </div>
        <div class="form-group">
          <label for="song-artist">Artiest</label>
          <input id="song-artist" class="form-control song-info" name="artist">
        </div>
        <button id="song-search" class="youtube btn btn-default">Zoeken</button>
      </form>
    </div>
  </div>

    <div id="video-finder" class="col-sm-7 hidden-xs sidebar">
      <div class="video-wrapper"><iframe id="video-preview" src=""></iframe></div>
      <div class="scroll-container">
        <!-- <tr class="video-result">
          <td class="video-thumbnail"><img src="https://i.ytimg.com/vi/68ugkg9RePc/default.jpg"></td>
          <td class="video-info">
            <span class="video-title">Eiffel 65 - Blue (Da Ba Dee) (Original Video with subtitles)</span>
          </td>
          <td>
            <button class="btn btn-default pull-right btn-play"><i class="glyphicon glyphicon-play"></i></button>
          </td>
        </tr> -->
        <table id="video-list">
        </table>
      </div>
    </div>

@stop
