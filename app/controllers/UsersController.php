<?php

class UsersController extends BaseController {

  public function __construct() {
    $this->beforeFilter('csrf', array('on'=>'post'));
  }

  /* RESTful Functions */

  public function index() {
    if (!(Auth::check() && Auth::user()->canManageUsers())) {
      return Redirect::to('/');
    }

    return View::make('users.index', array(
      'css' => 'users',
      'users' => User::all()
    ));
  }

  public function show($id) {
    $user = User::find($id);
    return View::make('users.show')->withUser($user);
  }

  public function create() {
    return View::make('users.signup', array("css" => "users"));
  }

  public function store()
  {
    $validator = Validator::make(Input::all(), User::$rules);

    if ($validator->passes()) {
      $user = new User;
      $user->username = Input::get('gebruikersnaam');
      $user->email = Input::get('email');
      $user->password = Hash::make(Input::get('wachtwoord'));
      $user->activation = generateRandomString(64);
      $user->activation_due = Carbon::now()->addWeek();
      $user->save();

      Session::flash('success', 'Gebruiker is toegevoegd, er is een mail gestuurd voor de bevestiging!');
      return Redirect::to('users/login');
      // Validation passed
    } else {
      // Validation didn't pass. :'(
      Session::flash('error', 'Er waren fouten met het opslaan');
      Debugbar::log($validator->messages());
      return Redirect::to('user/create')->withErrors($validator)->withInput();
    }
  }

  public function edit($id) {
    if (!Auth::check() || !(Auth::user()->canManageUsers() || Auth::user()->id == $id)) {
      return Redirect::to('/');
    }
    $user = User::find($id);
    return View::make('users.edit')->withUser($user);
  }

  public function update($id) {
    $user = User::find($id);

    $validator = Validator::make(Input::all(), User::$rulesUpdate);
    $validator->sometimes('function', 'unique:users', function($input) {
      return $input->function != "";
    });

    if ($validator->fails()) {
      Session::flash('error', 'Er waren fouten met het opslaan');
      Debugbar::log($validator->messages());
      return Redirect::action('user.edit', $id)->withErrors($validator)->withInput();
    }
    else {
      $user->username = Input::get('username');
      $user->function = Input::get('function');
      $user->save();

      Session::flash('success', 'Gebruiker is aangepast!');
      return Redirect::action('user.edit', $id);
    }
  }

  public function destroy($id) {
    // TODO
  }

  /* End RESTful Functions */

  /* Controller Functions */

  public function getIndex() {
    return $this->index();
  }

  public function getLogin() {
    return View::make('users.signin', array('css' => 'users'));
  }

  public function postLogin() {
    $input = array('username' => Input::get('gebruikersnaam'), 'password' => Input::get('wachtwoord'));
    if (Auth::attempt($input))
    {
      Session::flash('success', 'Succesvol ingelogd!');
      return Redirect::to('/');
    } else {
      Session::flash('error', 'Gebruikersnaam/wachtwoord combinatie niet gevonden');
      return Redirect::to('user/login')->withInput();
    }

  }

  public function getLogout() {
    Auth::logout();
    Session::flash('success', 'Succesvol uitgelogd!');
    return Redirect::to('/');
  }

  /* End Controller Functions */

}

?>
