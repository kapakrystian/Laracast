<?php


use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];
$errors = [];

//validate the form inputs
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if (!empty($errors)) {
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

//check if the account already exists
$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($user) {
    //then someone with that email already exists and has an account
    //if yes, redirect to a login page
    header('location: /');
    exit();
} else {
    //if no, save one to the database, and then log the user in, and redirect
    $db->query('INSERT INTO users(email, password) VALUES (:email, :password)', [
        'email' => $email,
        'password' => $password
    ]);

    //mark that the user has logged in
    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = [
        'email' => $email
    ];

    header('location: /');
    exit();
}
