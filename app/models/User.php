<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;


  public static $rules = array(
    'email'=>'required|email|unique:users',
    'wachtwoord'=>'required|alpha_num|confirmed|min:5',
    'wachtwoord_confirmation'=>'required|alpha_num|min:5',
    'gebruikersnaam'=>'required|alpha|unique:users,username|min:2'
  );

  public function canStartVoting()
  {
    Debugbar::log(Auth::user());

    return Auth::user()->username == "Admin";
  }

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token', 'activation', 'activation_due');

}
