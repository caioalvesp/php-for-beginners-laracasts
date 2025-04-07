<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm {
  protected $errors = [];

  public function validate($email, $password) {
    $errors = [];

    if (!Validator::email($email)) {
      $errors['email'] = 'Email is required.';
    };

    if (!Validator::string($password)) {
      $errors['password'] = 'Password is required.';
    };

    return empty($errors);
  }

  public function errors() {
    return $this->errors;
  }
}
