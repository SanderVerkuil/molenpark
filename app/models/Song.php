<?php

class Song extends Eloquent {

  protected $table = "song";
	protected $fillable = array("artist","title","youtube_key","requester");

  public function scopeRequests($query)
  {
    return $query->whereStatus('aangevraagd')->orderBy('updated_at', 'desc');
  }

}
