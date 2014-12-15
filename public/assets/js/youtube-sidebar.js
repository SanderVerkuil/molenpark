var renderer = new Renderer();

/* Functions */
function updateVideos() {
  UpdateYoutube();
  UpdateSpotify();
  UpdateLocal();
}

function UpdateYoutube()
{
  query = $("#song-search").val();

  // Switch info text
  $('.info-text.search-video').addClass("hidden");
  $('.info-text.select-video').addClass("hidden");
  $('.info-text.loading-video').removeClass("hidden");

  // AJAX request to fetch video results
  $.ajax(base_url + '/ajax/youtube', {
    data: {q:query},
    dataType: "json",
    error: function (e) {
      console.error("[YouTube] "+e.responseText);
    },
    success: function(result) {
      console.log("[YouTube] Success!");
      // Clear video preview
      $('#video-list').html("");
      $('#video-preview').attr("src", "");
      $('.video-wrapper').hide();

      // Switch info text
      $('.info-text.search-video').addClass("hidden");
      $('.info-text.loading-video').addClass("hidden");
      $('.info-text.select-video').removeClass("hidden");

      // Display video results
      $.each(result, function(i, vid) {
        if (vid.videoId != null)
        {
          var firstclass = "",
          reg = new RegExp("("+query+")","ig");

          if (i == 0) {
            firstclass = " first";
          }

          // Highlight search words using regex
          vid.title = vid.title.replace(reg, "<strong>$1</strong>");

          // This can be done easier, right?
          $('#video-list').append('<tr class="video-result'+firstclass+'" data-id="'+vid.videoId+'"><td class="video-thumbnail hidden-sm">'+responsiveThumbnail(vid.thumbnails)+'</td><td class="video-info"><span class="video-title">'+vid.title+'</span></td><td><button class="btn btn-danger btn-play"><i class="glyphicon glyphicon-play"></i></button></td></tr>'
            );
        }
      });
    }
  });
}

function UpdateSpotify()
{
  $.ajax(base_url + "/ajax/spotify/20", {
    data: {
      q: query
    },
    dataType: "json",
    error: function (e) {
      console.error("[Spotify] "+e.responseText);
    },
    success: function(data) {
      console.log("[Spotify] Success!");
      console.log(data);
      var options = {
        renderingContext: $("#spotify"),
        templateUrl: base_url + "assets/templates/results_spotify.mst",
        data: data,
        append: false,
        removeUnmatched: true,
        complete: function(output, context) {
          $(".preview-frame").hide(); 
          $(".spotify-result .btn").click(function(e) {
            e.preventDefault();

            $(".preview-frame").show();
            $("iframe.preview-frame").attr("src", "https://embed.spotify.com/?uri=" + $(this).parents("tr").attr("data-id"));
            e.stopPropagation();
          })
          $(".spotify-result").click(function(e) {
            e.preventDefault();

            $(this).siblings('.selected').removeClass('selected');
            $(this).toggleClass('selected');

            if ($(this).hasClass('selected'))
            {

              $("#song-title").val($(this).attr("data-track"));
              $("#song-artist").val($(this).attr("data-artist"));

              $("#song-link").val("https://embed.spotify.com/?uri=" + $(this).attr("data-id"));

              $("#song-title").attr("readonly", "");
              $("#song-artist").attr("readonly","");
              $("#song-link").attr("readonly", "");
            } else {
              $("#song-title").val("");
              $("#song-artist").val("");
              $("#song-link").val("");
              $("#song-link").removeAttr("readonly");
            }
          })
        }
      }
      renderer.render(options);
    },
  })
}

function UpdateLocal()
{
  var artist = $('#song-artist').val(),
  title = $('#song-title').val(),
  query = $("#song-search").val();

  // Don't accept empty artist or title
  if (artist == "" || title == "") {
    return false;
  }

  // AJAX request to search in database
  $.ajax('/ajax/songs', {
    data: {q:query},
    dataType: "json",
    success: function(result) {
      // WIP

    }
  });
}

function responsiveThumbnail(thumbs)
{
  // Make some images
  var low = $("<img></img>");
  var med = $("<img></img>");
  var high = $("<img></img>");

  // Set 3 different quality sources
  low.attr('src', thumbs.default.url);
  med.attr('src', thumbs.medium.url);
  high.attr('src', thumbs.high.url);

  // Low: medium and lower
  low.toggleClass('hidden-lg');
  // Med: large
  med.toggleClass('hidden-xs hidden-md');

  return med.prop('outerHTML') + low.prop('outerHTML');
}

function isFilled(field)
{
  // Also takes an array of field selectors
  if ($.isArray(field)) {
    var res = true;
    $.each(field, function (i,f) {
      res = res && $(f).val() != "";
    });
    return res;
  }

  return $(field).val() != "";
}
/* END functions */

/* Document Ready */
$(document).ready(function(){

  // Help text popovers
  $('.help').popover();

  $()
  // Show youtube search text
  $('.info-text.search-video').show();

  // Result play button click event
  $('#video-list').on("click", '.btn-play', function(e){
    // Get ID and make a youtube url
    var videoId = $(this).parents(".video-result").data("id"),
    ytUrl = "http://www.youtube.com/v?v="+videoId+"&autoplay=1";

    // Set source in preview iframe and show it
    $('#video-preview').attr("src",ytUrl);
    if (!$('#video-preview').is(":visible")) {
      $('.video-wrapper').slideDown();
    }
    // Prevent video selection
    e.stopPropagation();
  });

  // Video selection click event
  $('#video-list').on("click", '.video-result', function(){
    // Deselect all others
    $(this).siblings('.selected').removeClass("selected");
    $(this).toggleClass("selected");

    if ($(this).hasClass("selected")) {
      // On selection: set video link field
      var videoId = $(this).data("id");
      $('#song-link').val("http://www.youtube.com/watch?v=" + videoId);
      $('#song-yt-key').val(videoId);
      // Disable link field
      $('#song-link').attr("readonly", "");

      $("#song-artist").removeAttr("readonly");
      $("#song-title").removeAttr("readonly");

      if (!$('#song-form').hasClass("prefilled")) {
        $("#song-artist").val("");
        $("#song-title").val("");
      }
      else {
        $('#song-form').removeClass("prefilled");
      }
    }
    else {
      // On deselection: empty fields
      $('#song-link').val("");
      $('#song-link').removeAttr("readonly");

      $("#song-artist").attr("readonly", "");
      $("#song-title").attr("readonly", "");

      $("#song-artist").val("");
      $("#song-title").val("");
    }
  });

  // If search value is pre filled: search on page load
  if ($('#song-search').val() != "") {
    updateVideos();
  }

  // On song info change: update video results
  $('.song-info').change(updateVideos);
  
  // Check required fields when typing
  var required = new Array(
    '#song-link', '#song-title', '#song-artist', '#song-requester'
  );
  $('#song-form :input').keyup(function (){
    console.log(required);
    console.log(isFilled(required));
    if (isFilled(required)) {
      $('#song-submit').removeAttr("disabled");
    }
    else {
      $('#song-submit').attr("disabled", "");
    }
  });
  
  // Enable submit when everything is already prefilled
  if (isFilled(required)) {
    $('#song-submit').removeAttr("disabled");
  }

});
/* END document ready */
