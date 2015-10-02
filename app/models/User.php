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

  public static $rulesUpdate = array(
    'username' => 'sometimes|required|alpha|unique:users|min:2',
    'function' => 'sometimes|unique:users'
  );

  private static $permissions = array(
    'hoofd' => array('manage_users','start_vote'),
    'vice-hoofd' => array('start_vote'),
    '*' => array()
  );

  private static function checkPermission($function, $action) {
    if (is_null($function))
      $function = '*';

    return isset(User::$permissions[$function])
      ? in_array($action, User::$permissions[$function])
      : false;
  }

  public function canStartVoting()
  {
    if (!Auth::user())
      return false;

    return $this->checkPermission(Auth::user()->function, 'start_vote')
      || Auth::user()->username == "Admin";
  }

  public function canManageUsers()
  {
    if (!Auth::user())
      return false;

    return $this->checkPermission(Auth::user()->function, 'manage_users')
      || Auth::user()->username == "Admin";
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
