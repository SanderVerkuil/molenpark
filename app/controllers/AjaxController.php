<?php

class AjaxController extends BaseController {

	function songs($perPage = 5)
	{

    $artist = Input::get("artist");
    $title = Input::get("title");

    $data = Song::where('artist', 'LIKE', "%$artist%")->
    where('title',  'LIKE', "%$title%", 'AND')->orderBy('updated_at', 'DESC')->paginate($perPage);

    return Response::json($data);
  }

  function searchSpotify($maxResults = 10)
  {
    $curl = curl_init();
    $query = "Never gonna give you up";
    if (Input::has("q"))
      $query = Input::get("q");

    $query = urlencode($query);

    $url = "https://api.spotify.com/v1/search?q=$query&limit=$maxResults&type=track";

    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url,
      CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0"
      ));
    $response = curl_exec($curl);
    if(!$response){
      die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
    }

    $json = json_decode($response);

    $data['tracks'] = array();

    foreach ($json->tracks->items as $key => $track) {
      $track->album = $track->album->name;
      $artists = array();

      foreach($track->artists as $artist)
      {
        if (!in_array($artist->name, $artists))
          $artists[] = $artist->name;
      }

      $track->artists = implode(", ", $artists);
      $data['tracks'][] = $track;
    }

    return Response::json($data);

  }

  function searchYoutube($maxResults = 5)
  {
    $artist = "";
    $title = "";
    $query = "";

    if (Input::has("a"))
      $artist = Input::get('a');
    if (Input::has("t"))
      $title = Input::get("t");
    if (Input::has("q"))
      $query = Input::get("q");

    $client = new Google_Client();
    $client->setDeveloperKey("AIzaSyA9KWQHrYK-ByJRqyR727BFkvY0LUnecG8");

    $youtube = new Google_Service_YouTube($client);
    try {
      $response = $youtube->search->listSearch("id,snippet", array("q" => $query, "maxResults" => $maxResults));

      $items = array();

      foreach ($response->items as $item) {
        $items[] = array("videoId" => $item->id->videoId, "title" => $item->snippet->title, "description" => $item->snippet->description, "thumbnails" => array("default" => $item->snippet->thumbnails->default, "medium" => $item->snippet->thumbnails->medium, "high" => $item->snippet->thumbnails->high));
      }

      return Response::json($items);
    } catch (Google_ServiceException $e) {
      printf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
      printf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    }
  }

}
