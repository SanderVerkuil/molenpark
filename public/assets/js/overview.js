var renderer = new Renderer();

$(document).ready(function() {


  $(window).hashchange(function(e) {
    LoadPage();
  })

  LoadPage();

  $("#search").submit(function(e) {
    console.log("submitted");
    LoadPage();
    e.preventDefault();
  });
  $(".song-search").keyup(LoadPage);
})

function LoadPage()
{
  var values, info = {};

  var array = location.hash.substr(1).split('&');

  for (var i = 0; i < array.length; i += 1)
  {
    var values = array[i].split('=');

    info[values[0]] = values[1];
  }

  url = base_url + "ajax/songs/1?page=" + (info.page != undefined ? info.page :  '');

  $.ajax({
    url: url,
    data: {
      'artist': $("#artiest").val(),
      'title': $("#title").val()
    },
    complete: function(jqxhr) {
      renderer.render({
        renderingContext: $('#overview'),
        templateUrl: "assets/templates/overview.mst",
        data: jqxhr.responseJSON,
        paginate: {
          run: true,
          left: 3,
          right: 3
        },

      });
    },
    dataType: "json",
    cache: false
  })
}
