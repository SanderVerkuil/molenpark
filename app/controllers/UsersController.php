<?php

class UsersController extends BaseController {

  public function __construct() {
    $this->beforeFilter('csrf', array('on'=>'post'));
  }

  public function getRegister() {
    return View::make('users.signup', array("css" => "users"));
  }

  public function postCreate()
  {
    $validator = Validator::make(Input::all(), User::$rules);

    if ($validator->passes()) {
      $user = new User;
      $user->username = Input::get('username');
      $user->email = Input::get('email');
      $user->password = Hash::make(Input::get('password'));
      $user->activation = generateRandomString(64);
      $user->activation_due = Carbon::now()->addWeek();
      $user->save();

      Session::flash('success', 'Gebruiker is toegevoegd, er is een mail gestuurd voor de bevestiging!');
      return Redirect::to('users/login');
      // Validation passed
    } else {
      // Validation didn't pass. :'(
      Session::flash('error', 'Er waren fouten met het opslaan');
      return Redirect::to('users/register')->withErrors($validator)->withInput();
    }
  }

  public function getLogin() {
    return View::make('users.signin', array('css' => 'users'));
  }

  public function postLogin() {
    $input = array('username' => Input::get('username'), 'password' => Input::get('password'));
    if (Auth::attempt($input))
    {
      Session::flash('success', 'Succesvol ingelogd!');
      return Redirect::to('/');
    } else {
      Session::flash('error', 'Gebruikersnaam/wachtwoord combinatie niet gevonden');
      return Redirect::to('users/login')->withInput();
    }

  }

  public function getLogout() {
    Auth::logout();
    Session::flash('success', 'Succesvol uitgelogd!');
    return Redirect::to('/');
  }

}

?>
