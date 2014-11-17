<?php

class UsersController extends BaseController {

  public function getRegister() {
    return View::make('users.signup', array("css" => "users"));
  }

}

?>
