<?php

class Song extends Eloquent {

  protected $table = "song";
	protected $fillable = array("artist","title","link","youtube_key","requester");

  public function scopeRequests($query)
  {
    return $query->whereStatus('aangevraagd')->orderBy('updated_at', 'desc');
  }

  public function scopeInVote($query)
  {
    $current = Voting::current();

    if ($current->count() > 0) {
      $current = $current->first();
      // $previous = Voting::where('ended', '<', $current->created_at);
      $query = $query->whereVoted(false)
        ->where('created_at', '<=', $current->created_at);

      /*if ($previous->count() > 0) {
        $previous = $previous->first();
        $query = $query->where('created_at', '>', $previous->ended);
      }*/
      return $query->orderBy('created_at', 'desc');
    }

    return $query;
  }

  public function scopeVotedYes($query)
  {
    return $query->whereStatus('ingestemd')->orderBy('updated_at', 'desc');
  }

}
