@extends("layouts/master")

@section("content")
Artist: {{ $artist }}
Title: {{ $title }}

<a href="https://www.youtube.com/results?search_query={{ $artist }}+-+{{ $title }}">Youtube search</a>
@endsection
