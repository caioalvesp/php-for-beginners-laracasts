<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];
if (!Validator::email($email)) {
  $errors['email'] = 'Email is required.';
};

if (!Validator::string($password, 7, 255)) {
  $errors['password'] = 'Password is required.';
};

if (! empty($errors)) {
  return view('registration/create.view.php', [
    'errors' => $errors,
  ]);
}

$user = $db->query('SELECT * FROM users WHERE email = :email', [
  'email' => $email,
])->find();

if ($user) {
  header('location: /');
  exit();
} else {
  $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT)
  ]);

  login($user);

  header('location: /');
  exit();
}
