@extends('layouts/master')

@section('content')
<h1>Stemmen <a href="{{URL::to('vote/start')}}" role="button" class="btn btn-primary btn-lg">Start Sessie</a></h1>
<h2>Aangevraagd ({{count($songs)}}):</h2>
<table id="requests" class='table-striped table table-bordered table-hover'>
  <thead>
    <tr>
      <th class="artist">Artiest</th>
      <th class="track">Titel</th>
      <th class="requester">Aanvrager</th>
      <th class="hidden-xs hidden-sm">Aangevraagd op</th>
      <th class="hidden-xs hidden-sm">Laatste update</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($songs as $s)
    <tr>
      <td class="artist">{{$s->artist}}</td>
      <td class="track">{{$s->title}}</td>
      <td class="requester">{{$s->requester}}</td>
      <td class="requested hidden-xs hidden-sm">{{date("d-m-Y H:i", strtotime($s->created_at))}}</td>
      <td class="lastUpdate hidden-xs hidden-sm">{{date("d-m-Y H:i", strtotime($s->updated_at))}}</td>
    </tr>
  @endforeach
  </tbody>
</table>
@stop
