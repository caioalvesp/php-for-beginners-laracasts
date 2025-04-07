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

if (!Validator::string($password)) {
  $errors['password'] = 'Password is required.';
};

if (! empty($errors)) {
  return view('session/create.view.php', [
    'errors' => $errors
  ]);
}

$user = $db->query('select * from users where email = :email', [
  'email' => $email
])->find();

if ($user) {
  if (password_verify($password, $user['password'])) {
    login([
      'email' => $email,
    ]);

    header('location: /');
    exit();
  }
}

return view('session/create.view.php', [
  'errors' => [
    'email' => 'No matching account found for this email address and password.'
  ]
]);
