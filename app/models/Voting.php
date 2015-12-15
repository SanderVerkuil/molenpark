<?php

class Voting extends \Eloquent {
	protected $fillable = ['ended', 'created_by'];
	protected $table = "votings";

  public function scopeCurrent($query)
  {
    return $query->where('created_at', '<=', date('Y-m-d H:i:s'))->whereEnded(NULL);
  }
}