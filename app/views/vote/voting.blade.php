@extends('layouts/master')

@section('content')

<div id="songdata" style="display:none">{{json_encode($songs)}}</div>

<div class="row">
  
  <div class="col-md-4 col-sm-5 sidebar hidden-xs">

    <pre>created_at: {{$voting->created_at}}
created_by: {{$voting->created_by}}</pre>

    <table class="queue">
      @foreach($songs as $i => $song)
      <tr class="<?= $song->voted ? "voted" : "to-go" ?>" id="song{{$song->id}}">
        <td class="artist">{{$song->artist}}</td>
        <td class="title">{{$song->title}}</td>
        <td class="requester">{{$song->requester}}</td>
      </tr>
      @endforeach
    </table>

    <div id="status">
      To go: <span class="num-left">??</span>
    </div>

  </div>

  <div class="col-md-8 col-sm-7 main">

    <h1 id="current-song"><span class="artist">[ARTIST]</span> - <span class="title">[TITLE]</span></h1>

    <div class="preview-container">
      <div id="player"></div>
    </div>

    <div class="row vote-buttons">
      <div class="col-xs-3"><button id="vote-yes" class="btn-vote btn btn-lg btn-block btn-success" title="Nummer INGESTEMD">JA</button></div>
      <div class="col-xs-3"><button id="vote-no" class="btn-vote btn btn-lg btn-block btn-danger" title="Nummer UITGESTEMD">NEE</button></div>
      <div class="col-xs-3"><button id="skip-30s" class="btn-vote btn btn-lg btn-block btn-primary" title="Skip 30 seconden vooruit">+30s</button></div>
      <div class="col-xs-3"><button id="skip-to-1m" class="btn-vote btn btn-lg btn-block btn-primary" title="Skip naar 1:00">@1m</button></div>
    </div>

  </div>

</div>

@stop