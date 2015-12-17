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

		$artist = DB::getPdo()->quote($song['artist']);
		$title = DB::getPdo()->quote($song['title']);

		if (Song::whereRaw("LOWER(artist) = LOWER($artist) AND LOWER(title) = LOWER($title)")->count() > 0) {
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
		return Config::get('enum.songstatus')[$statusId];
	}

	private function curlRequest($url)
	{
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0",
			CURLOPT_SSL_VERIFYPEER => false
		));
		$response = curl_exec($ch);
		if (!$response){
			die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		}
		return $response;
	}

	public function getSearchItunes($songId)
	{
		$song = Song::findOrFail($songId);
		$term = urlencode($song->artist.' '.$song->title);
		$urlBase = 'https://itunes.apple.com/search?media=music&country=nl&term=';
		$url = $urlBase.$term;

		$results = json_decode($this->curlRequest($url));

		if ($results->resultCount == 0) {
			$term = $song->title;
			$url = $urlBase.$term;
			$results = json_decode($this->curlRequest($url));

			if ($results->resultCount == 0) {
				$term = $song->artist;
				$url = $urlBase.$term;
				$results = json_decode($this->curlRequest($url));
			}
		}

		return View::make('songs.itunes', array(
			'song' => $song,
			'results' => $results->results
		));
	}

	function getVoteResults()
	{
		if (!Auth::check())
			return Redirect::to('/login');

		if (!Auth::user()->canBuySongs())
			return Redirect::to('/');

		if (Input::get('uitgestemd'))
			$songs = Song::whereVoted(true)->orderBy('updated_at', 'desc')->get();
		else
			$songs = Song::votedYes()->get();
		return View::make('songs.votes', array(
			'javascripts' => array('emptor'),
			'songs' => $songs
		));
	}

}
