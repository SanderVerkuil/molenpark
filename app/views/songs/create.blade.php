@extends('layouts/master')

@section('content')
  <div class="row">
    <div class="col-sm-6 youtube-search">
      <form id="song-form" role="form" method="post">

        {{-- Artist --}}
        <div class="form-group">
          <label for="song-artist">Artiest</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
            <input type="text" name="artist" id="song-artist" class="song-info form-control" placeholder="bijv. Rick Astley">
          </div>
        </div>

        {{-- Title --}}
        <div class="form-group">
          <label for="song-title">Titel</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-music"></span></div>
            <input type="text" name="title" id="song-title" class="song-info form-control" placeholder="bijv. Never Gonna Give You Up">
          </div>
        </div>

        {{-- Listening Link --}}
        <div class="form-group">
          <label for="song-link">Luisterlink</label> <a href="#" class="help" tabindex="2" data-toggle="popover" data-trigger="focus" title="Wat is een luisterlink?" data-content="Om te beoordelen of we een nummer in de collectie willen hebben, moeten we hem wel kunnen beluisteren :) Als er geen YouTube video van je nummer is, dump hier dan een link naar Soundcloud of iets dergelijks.">(?)</a>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-headphones"></span></div>
            <input type="text" name="link" id="song-link" class="form-control" placeholder="http://...">
          </div>
        </div>

        {{-- Requester --}}
        <div class="form-group">
          <label for="song-title">Aanvrager</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-bullhorn"></span></div>
            <input type="text" name="requester" id="song-requester" class="form-control" placeholder="bijv. Je Moeder">
          </div>
        </div>

        {{-- Submit --}}
        <button id="song-search" class="btn btn-lg btn-block btn-large btn-primary" disabled><span class="glyphicon glyphicon-ok pull-left" style="padding-left:10px"></span> Aanvragen</button>

      </form>
    </div>

    {{-- Video Sidebar --}}
    <div id="video-finder" class="col-sm-6 hidden-xs sidebar">
      <div class="video-wrapper"><iframe id="video-preview" src=""></iframe></div>
      <h4 class="info-text search-video">Voer artiest en titel in om te zoeken op YouTube</h4>
      <h4 class="info-text select-video">Selecteer een video voor de luisterlink</h4>
      <div class="scroll-container">
        <table id="video-list">
        </table>
        <table id="song-list">
          <!-- Song results from DB will go in here -->
        </table>
      </div>
    </div>
  </div>
@stop
