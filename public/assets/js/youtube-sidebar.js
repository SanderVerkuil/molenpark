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

        $('#video-list').append('<tr class="video-result'+firstclass+'" data-id="'+vid.videoId+'"><td class="video-thumbnail hidden-sm">'+responsiveThumbnail(vid.thumbnails)+'</td><td class="video-info"><span class="video-title">'+vid.title+'</span></td><td><button class="btn btn-danger btn-play"><i class="glyphicon glyphicon-play"></i></button></td></tr>'
        );
      });
    }
  });
}

function responsiveThumbnail(thumbs)
{
  var low = $("<img></img>");
  var med = $("<img></img>");
  var high = $("<img></img>");

  low.attr('src', thumbs.default.url);
  med.attr('src', thumbs.medium.url);
  high.attr('src', thumbs.high.url);

  low.toggleClass('hidden-lg');
  med.toggleClass('hidden-xs hidden-md');

  return med.prop('outerHTML') + low.prop('outerHTML');
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
