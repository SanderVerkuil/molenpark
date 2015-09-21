<?php

class VoteController extends BaseController {
  
  public function getIndex() {
    // Needs logged in user with voting privileges
    if (!(Auth::check() && Auth::user()->canStartVoting())) {
      return Redirect::to('/');
    }

    $songs = Song::requests()->get();

    return View::make('vote.index', array(
      'songs' => $songs
    ));
  }

}
