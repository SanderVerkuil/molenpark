<?php

class VoteController extends BaseController {
  
  public function getIndex() {
    // Needs logged in user with voting privileges
    if (!(Auth::check() && Auth::user()->canStartVoting())) {
      return Redirect::to('/');
    }

    $songs = Song::requests()->get();
    $current = Voting::current();

    if ($current->count() == 0)
      return View::make('vote.index', array(
        'songs' => $songs
      ));
    else {
      $songs = Song::inVote()->get();
      $voting = $current->first();
      $voting->created_by = User::find($voting->created_by)->username;

      // Randomize songs
      $songs = $songs->all();
      // Seed randomizer with voting ID to ensure consistent song order
      mt_srand($voting->id);
      $order = array_map(create_function('$val', 'return mt_rand();'), range(1, count($songs)));
      array_multisort($order, $songs);

      return View::make('vote.voting', array(
        'css' => array('voting'),
        'javascripts' => array('voting'),
        'songs' => $songs,
        'voting' => $voting
      ));
    }
  }

  public function getStart() {
    // Needs logged in user with voting privileges
    if (!(Auth::check() && Auth::user()->canStartVoting())) {
      return Redirect::to('/');
    }

    $current = Voting::current()->get();

    if (count($current) == 0) {
      if (Song::requests()->count() > 0) {
        $voting = new Voting();
        $voting->created_by = Auth::user()->id;
        $voting->save();
      }
      else {
        Session::flash('error', 'Geen nummers om over te stemmen! D:');
      }
    }

    return Redirect::to('/vote');
  }

}
