@extends('layouts/master')

@section('content')
<div class="row">
  <div class="col-sm-6 form-container">
    <form id="song-form" role="form" method="post" action="/song/store" @if (Input::has('artist') || Input::has('title')) class="prefilled" @endif>

      {{-- Search --}}
      <div class="form-group">
        <label for="song-search">Zoeken</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
          <input type="text" name="search" id="song-search" class="song-info form-control" value="{{ implode(' - ',array_filter(Input::only('artist','title')) ) }}" placeholder="bijv. Rick Astley - Never Gonna Give You Up" />
        </div>
      </div>

      {{-- Artist --}}
      <div class="form-group">
        <label for="song-artist">Artiest</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
          <input type="text" name="artist" id="song-artist" class="song-info form-control" value="{{titleCase(Input::get('artist'))}}" readonly placeholder="bijv. Rick Astley">
        </div>
      </div>

      {{-- Title --}}
      <div class="form-group">
        <label for="song-title">Titel</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-music"></span></div>
          <input type="text" name="title" id="song-title" class="song-info form-control" value="{{titleCase(Input::get('title'))}}" readonly placeholder="bijv. Never Gonna Give You Up">
        </div>
      </div>

      {{-- Listening Link --}}
      <div class="form-group">
        <label for="song-link">Luisterlink<span>&trade;</span></label> <a href="#" class="help" tabindex="2" data-toggle="popover" data-trigger="focus" title="Wat is een luisterlink?" data-content="Om te beoordelen of we een nummer in de collectie willen hebben, moeten we hem wel kunnen beluisteren :) Als er geen YouTube video van je nummer is, dump hier dan een link naar Soundcloud of iets dergelijks.">(?)</a>
        @if ($errors->song->has("link"))
        <p>{{$errors->song->first("link")}}</p>
        @endif
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-headphones"></span></div>
          <input type="text" name="link" id="song-link" class="form-control" placeholder="http://...">
          <input type="hidden" name="youtube_key" id="song-yt-key" value="">
        </div>
      </div>

      {{-- Requester --}}
      <div class="form-group">
        <label for="song-requester">Aanvrager</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-bullhorn"></span></div>
          @if (Auth::check())
          <input type="text" name="requester" class="form-control" value="{{ucfirst(Auth::user()->username)}}" placeholder="bijv. Je Moeder">
          {{-- <input type="hidden" name="requester" id="song-requester" value="{{ucfirst(Auth::user()->username)}}"> --}}
          @else
          <input type="text" name="requester" id="song-requester" class="form-control" value="{{Cookie::get('requester')}}" placeholder="bijv. Je Moeder">
          @endif
        </div>
        <div class="checkbox">
          @if (Auth::check())
          {{-- <label class="checkbox-inline">
            <input type="checkbox" name="song-priority"> Top 5 / Priority
          </label> --}}
          @else
          <label class="checkbox-inline">
            <input type="checkbox" name="remember-requester" @if (Cookie::get('requester')) checked="checked" @endif> Onthoud mij
          </label>
          @endif
        </div>
      </div>

      {{-- Submit --}}
      <button id="song-submit" class="btn btn-lg btn-block btn-large btn-primary" disabled><span class="glyphicon glyphicon-ok pull-left" style="padding-left:10px"></span> Aanvragen</button>

    </form>
  </div>

  {{-- Tabs --}}
  <div id="tab-container" class="col-sm-6">
    {{-- Tab navigation --}}
    <ul class="nav nav-tabs nav-justified" role="tablist">
      <li class="active"><a href="#youtube" role="tab" data-toggle="tab">YouTube</a></li>
      <li><a href="#spotify" role="tab" data-toggle="tab">Spotify</a></li>
      <li><a href="#soundcloud" role="tab" data-toggle="tab">SoundCloud</a></li>
    </ul>

    {{-- Tab panels --}}
    <div class="tab-content">
      <div class="tab-pane active" id="youtube">
        {{-- YouTube --}}
        <div class="video-wrapper"><iframe id="video-preview" frameborder="0" src=""></iframe></div>
        <div class="well well-sm info-text search-video"><h4 class="text-center">Begin links met zoeken</h4></div>
        <div class="well well-sm info-text loading-video hidden"><h4 class="text-center">Zoeken...</h4></div>
        <div class="well well-sm info-text select-video hidden"><h4 class="text-center">Selecteer een video voor de luisterlink</h4></div>
        <div class="scroll-container">
          <table id="video-list" class="table">

          </table>
        </div>
        {{-- /YouTube --}}

      </div>
      <div class="tab-pane" id="spotify">
        {{-- Spotify --}}
        <div class='well well-sm info-text'>
          <h4 class="text-center">Begin links met zoeken</h4>
        </div>
      </div>
      <div class="tab-pane" id="soundcloud">
        {{-- Soundcloud --}}
        <div class="well well-sm info-text">
        <h4 class="text-center">SoundCloud&#153; is nog niet geimplementeerd</h4>
        </div>

      </div>
    </div>
    {{-- Video Sidebar --}}
  </div>
</div>
@stop
