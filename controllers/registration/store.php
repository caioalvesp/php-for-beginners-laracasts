<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

// validate the form inputs
$errors = [];

if (!Validator::email($email)) {
  $errors['email'] = 'Email is required.';
};

if (!Validator::string($password, 7, 255)) {
  $errors['password'] = 'Password is required.';
};

if (!empty($errors)) {
  return view('registration/create.view.php', [
    'errors' => $errors,
  ]);
}

// check if the account already exists
$db = App::resolve(Database::class);

$user = $db->query('SELECT * FROM users WHERE email = :email', [
  'email' => $email,
])->find();

if ($user) {
  // then someone with that email already exists and has an account.
  // if yes, redirect to a login page.
  header('location: /');
  exit();
} else {
  // if not, save one to the database, and then log them in, and redirect.
  $db->query('INSERT INTO users (email, password) VALUES (:email, :password)', [
    'email' => $email,
    'password' => $password
  ]);

  //mark that the user is logged in.
  $_SESSION['user'] = [
    'email' => $email,
  ];

  header('location: /');
  exit();
}
