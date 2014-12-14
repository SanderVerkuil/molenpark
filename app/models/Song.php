<?php

class Song extends Eloquent {

  protected $table = "song";
	protected $fillable = array("artist","title","youtube_key","requester");

}
