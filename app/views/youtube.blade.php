@extends("layouts/master")

@section("content")

<pre>
  @foreach ($data->items as $searchresult)
    {{ $searchresult->id->videoId}}
  @endforeach
</pre>
Artist: {{ $artist }}
Title: {{ $title }}

<a href="https://www.youtube.com/results?search_query={{ $artist }}+-+{{ $title }}">Youtube search</a>
@endsection

