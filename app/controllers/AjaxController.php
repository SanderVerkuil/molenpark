<?php

class AjaxController extends BaseController {

	function getSongs($perPage = 5)
	{

    global $artist;
    $artist = Input::get("artist");
    $title = Input::get("title");

    $data = Song::where(function($q){
      global $artist;
      $q->where('artist', 'LIKE', "%$artist%");
    })->where('title',  'LIKE', "%$title%", 'AND')->orderBy('updated_at', 'DESC')->paginate($perPage);

    return Response::json($data);
  }

  function getFreebase($maxResults = 10)
  {
    return Response::json($this->searchFreebase(Input::get("q"), $maxResults));
  }

  function getRandomImage($subreddit = "cats")
  {
    $url = "http://reddit.com/r/$subreddit/.json";

    $json = json_decode(file_get_contents($url));

    $regex = "/http(s)?:\/\/i\.imgur\.com\/[a-z0-9]*.(jpg|png)/i";

    Debugbar::log(count($json->data->children));

    do {
      $image = rand(1, count($json->data->children))-1;

      $url = $json->data->children[$image]->data->url;
    } while (!preg_match($regex, $url));

    return Response::make(file_get_contents($url), 200, ['content-type' => 'image/jpg']);
  }

  function getSpotify($maxResults = 10)
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
      CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0",
      CURLOPT_SSL_VERIFYPEER => false
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

  function getSoundcloud($maxResults = 5)
  {
    $query = "";

    $clientid = "7e964ef8cdefc4e90805318b1848c0ba";
    $clientsecret = "453bf2bb44c53b92ea58201b5e943fc4";

    if (Input::has("q"))
      $query = Input::get("q");

    return Response::json($query);
  }

  private function searchFreebase($query, $maxResults = 10)
  {
    $client = new Google_Client();
    $client->setDeveloperKey("AIzaSyA9KWQHrYK-ByJRqyR727BFkvY0LUnecG8");

    $freebase = new Google_Service_Freebase($client);

    $response = $freebase->search(array("query" => $query, "limit" => $maxResults, "type" => "/music/recording"));

    return $response["result"];
  }

  public function getFreebaseinfo($mid)
  {
    $client = new Google_Client();
    $client->setDeveloperKey("AIzaSyA9KWQHrYK-ByJRqyR727BFkvY0LUnecG8");

    $freebase = new Google_Service_Freebase($client);

    $response = $freebase->topic("/m/$mid");

    return Response::json($response);

  }

  function getYoutube($maxResults = 5)
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
      $response = $youtube->search->listSearch("id,snippet", array("q" => $query, "maxResults" => $maxResults, "videoEmbeddable" => "true", "type" => "video" ));

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

  function getStartVote()
  {

  }

}
