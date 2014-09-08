@extends('layouts/master')

@section('styles')
<link rel=stylesheet href="{{ asset('assets/css/video-finder.css'); }}">
<style type="text/css">
  #video-finder {
    position: absolute;
    top: 51px;
    right: 0;
    bottom: 0;
  }
</style>
@stop

@section('content')
  
  <script type="text/javascript">

    function updateVideos(artist, title) {
      $.ajax('/ajax/youtube', {
        data: {a:artist, t:title},
        dataType: "json",
        success: function(result) {
          $('#video-list').html("");
          $('#video-preview').attr("src", "");
          $('.video-wrapper').hide();

          $.each(result, function(i, vid) {
            var firstclass = "",
                reg = new RegExp("("+artist+"|"+title+")","ig");
            if (i == 0) {
              firstclass = " first";
            }

            vid.title = vid.title.replace(reg, "<strong>$1</strong>");

            $('#video-list').append('<tr class="video-result'+firstclass+'" data-id="'+vid.videoId+'"><td class="video-thumbnail hidden-sm"><img src="'+vid.thumbnails.default.url+'"></td><td class="video-info"><span class="video-title">'+vid.title+'</span></td><td><button class="btn btn-danger btn-play"><i class="glyphicon glyphicon-play"></i></button></td></tr>'
            );
          });
        }
      });
    }

    $(document).ready(function(){

      $('#video-list').on("click", '.btn-play', function(e){
        var videoId = $(this).parents(".video-result").data("id"),
            ytUrl = "http://www.youtube.com/v?v="+videoId+"&autoplay=1";
        console.log(ytUrl);
        $('#video-preview').attr("src",ytUrl);
        if (!$('#video-preview').is(":visible")) {
          $('.video-wrapper').slideDown();
        }
        e.stopPropagation();
      });

      $('#video-list').on("click", '.video-result', function(){
        $(this).toggleClass("selected");
        $(this).siblings('.selected').removeClass("selected");
      });

      $('.song-info').change(function(){
        var artist = $('#song-artist').val(),
            title = $('#song-title').val();
        if (artist !== "" && title !== "") {
          updateVideos(artist, title);
        }
      });

    });

  </script>

  <div class="row">

    <div class="col-sm-7">
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

    <div id="video-finder" class="col-sm-5 hidden-xs">
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

  </div>

@stop
