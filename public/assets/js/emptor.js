var loaded = {};
$('.btn-itunes').each(function() {
  var songId = $(this).parents('tr').data("songId");
  loaded[songId] = false;
});

function loadItunesPage(songId) {
  var modal = $('#songModal'+songId +' .modal-body');
  modal.html('Loading...');
  $.get('/songs/search-itunes/'+songId, function(html) {
    modal.html(html);
    loaded[songId] = true;
  });
}

$('.btn-itunes').click(function() {
  var songId = $(this).parents('tr').data("songId");
  if (!loaded[songId]) {
    loadItunesPage(songId);
  }
});

$('#filter-form :input').change(function() {
  $(this).parents('form').submit();
})