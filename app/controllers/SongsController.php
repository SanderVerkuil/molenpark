<?php

use Illuminate\Routing\Controller;

class SongsController extends Controller {

	/**
	 * Display a listing of songs
	 *
	 * @return Response
	 */
	public function index()
	{
		$js = array('jquery.hashchange.min', 'renderer' ,'overview');
		$css = "overview";

		return View::make('songs.index', array("css" => $css, "javascripts" => $js));
	}

	/**
	 * Show the form for creating a new song
	 *
	 * @return Response
	 */
	public function create()
	{
		$css = array("video-finder");
		$js = array("renderer","youtube-sidebar");
		return View::make('songs.create', array("css" => $css, "javascripts" => $js));
	}

	/**
	 * Store a newly created song in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Set rules for validator
		$rules = array(
			"artist" => "required",
			"title" => "required",
			"requester" => "required",
			"link" => "required|url"
		);

		// Validate input
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
				// TODO: Remember form input...
        return Redirect::to('song/create')->withErrors($validator, "song");
    }

    // Create new song
    $song = Input::all();

		// Set or unset remember cookie
		if (isset($song['remember-requester'])) {
			$cookie = Cookie::make("requester", $song['requester']);
		}
		else {
			$cookie = Cookie::forget("requester");
		}

    if (!is_null(Song::whereRaw("LOWER(artist) = '".strtolower($song['artist'])."' OR LOWER(title) = '".strtolower($song['title'])."'"))) {
    	return Redirect::to('song/create')->with('error', "HEBBEN WE AL!!!")->withCookie($cookie);
    }

		Song::create($song);

		// Set success message
		$msg = "Gefeliciteerd! Je nummer is aangevraagd :D";

		// Redirect to song index page with message and cookie
		return Redirect::to("/")->with("success", $msg)->withCookie($cookie);
	}

	/**
	 * Display the specified song.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$song = Song::findOrFail($id);

		return View::make('songs.show', compact('song'));
	}

	/**
	 * Show the form for editing the specified song.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$song = Song::find($id);

		return View::make('songs.edit', compact('song'));
	}

	/**
	 * Update the specified song in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$song = Song::findOrFail($id);

		$song->update(Request::get());

		return Redirect::route('songs.index');
	}

	/**
	 * Remove the specified song from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Song::destroy($id);

		return Redirect::route('songs.index');
	}

	public static function searchYoutube($artist, $title)
	{
		$apikey = "";
		$request = "";

		$DEVELOPER_KEY="AIzaSyA9KWQHrYK-ByJRqyR727BFkvY0LUnecG8";

		$client = new Google_Client();
		$client->setDeveloperKey($DEVELOPER_KEY);

		$youtube = new Google_Service_YouTube($client);

		try {
			$response = $youtube->search->listSearch('id,snippet', array('q' => $artist . " - " . $title, 'maxResults' => 5,));

			$videos = '';
			$channels='';
			$playlists='';
		} catch (Google_ServiceException $e) {
    	$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      	htmlspecialchars($e->getMessage()));
  	} catch (Google_Exception $e) {
    	$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
     		htmlspecialchars($e->getMessage()));
  	}

		$artist = urlencode($artist);
		$title = urlencode($title);

		$data = $response;

		return View::make("youtube", array("artist" => $artist, "title" => $title, "data" => $data));
	}

	public static function getStatus($statusId)
	{
		return $status[$statusId];
	}

	private $status = array(
		0 => "aangevraagd",
	  1 => "ingestemd",
	  2 => "uitgestemd",
	  3 => "gekocht MP3",
	  4 => "gekocht CD",
	  5 => "onvindbaar",
	  6 => "in collectie"
	);

}
