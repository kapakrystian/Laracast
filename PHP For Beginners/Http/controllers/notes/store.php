<?php


use Core\Validator;
use Core\App;
use Core\Database;

$db = App::container()->resolve(Database::class); //string z pełnym namespace'em klasy

$errors = [];

if (!Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}

if (!empty($errors)) {
    view("notes/create.view.php", [
        'heading' => 'Create Note',
        'errors' => $errors
    ]);
}

$db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
    'body' => $_POST['body'],
    'user_id' => $_SESSION['user']['id']
]);

header('location: /notes');
die();
