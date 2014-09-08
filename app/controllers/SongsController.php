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
		$songs = Song::all();

		return View::make('songs.index', compact('songs'));
	}

	/**
	 * Show the form for creating a new song
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('songs.create');
	}

	/**
	 * Store a newly created song in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Song::create(Request::get());

		return Redirect::route('songs.index')->with();
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

		$artist = urlencode($artist);
		$title = urlencode($title);

		return View::make("youtube", array("artist" => $artist, "title" => $title));
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
