// Dynamically load the YouTube API script
function loadIframeAPI() {
  var tag = document.createElement('script');

  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

var player;
// YouTube API callback
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    videoId: 'dQw4w9WgXcQ',
    width: '100%',
    height: '100%',
    events: {
      'onReady': onPlayerReady
    }
  });
}

function onPlayerReady(event) {
  //event.target.playVideo();

  // Bind events
  $('#skip-30s').click(function() {
    player.seekTo(player.getCurrentTime() + 30);
    player.playVideo();
  });
  $('#skip-to-1m').click(function() {
    player.seekTo(60);
    player.playVideo();
  });

  $('#vote-yes, #vote-no').click(function() {
    var songId = songs[current].id;
    $.post('/ajax/vote/'+songId, {vote: $(this).is('#vote-yes') ? "YES" : "NO"},
      function(r) {
        console.log(r);
      });

    $('#song'+songId).removeClass(classes.current)
      .addClass(classes.done);

    loadSong(current + 1);
  });

  // Load song data
  initSongs();
  loadSong(startAt);
}

/* Config */
var classes = {
    current: 'current bg-primary',
    toGo: 'to-go',
    done: 'voted'
  };

var songs, startAt, current;
function initSongs() {
  songs = JSON.parse($('#songdata').html());

  $.each(songs, function(i, song) {
    if (song.voted === "0") {
      startAt = i;
      return false;
    }
  });
}

function loadSong(n) {
  if (n < songs.length) {
    // Next song
    var song = songs[n];
    current = n;
    $('#status .num-left').text(songs.length - current);

    $('#song'+song.id).addClass(classes.current);
    $('#current-song .artist').text(song.artist);
    $('#current-song .title').text(song.title);
    player.loadVideoById(song.youtube_key);
  }
  else {
    // End voting
    $.post('/ajax/end-voting', function(r) {
      if (r === true) {
        window.location = "/";
      }
      else {
        console.log(r);
      }
    });
  }
}

/* Running code */

loadIframeAPI();