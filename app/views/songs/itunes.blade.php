<style>
  .table>tbody>tr>td {
    vertical-align: middle;
  }

  td.price {
    white-space: nowrap;
  }
</style>

@if($results)

<table class="table table-striped table-hover">
  <thead>
    <tr>
      {{-- <th></th> --}}
      <th>Artiest</th>
      <th>Titel</th>
      <th>Album</th>
      <th>Genre</th>
      <th>Prijs</th>
    </tr>
  </thead>
  <tbody>
  @foreach($results as $r)
    @if($r->kind == 'song')
    <tr>
      {{-- <td><img src="{{$r->artworkUrl30}}" alt=""></td> --}}
      <td><a target="_blank" href="{{$r->artistViewUrl}}">{{$r->artistName}}</a></td>
      <td><a target="_blank" href="{{$r->trackViewUrl}}">{{$r->trackName}}</a></td>
      <td><a target="_blank" href="{{$r->collectionViewUrl}}">{{$r->collectionName}}</a></td>
      <td>{{$r->primaryGenreName}}</td>
      @if($r->trackPrice == -1)
      <td class="price">Alleen album</td>
      @else
      <td class="price">{{$r->trackPrice}} {{$r->currency}}</td>
      @endif
    </tr>
    @endif
  @endforeach
  </tbody>
</table>

@else

<p>Niks gevonden...</p>

@endif