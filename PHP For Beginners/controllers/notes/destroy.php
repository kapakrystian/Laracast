<?php


use Core\App;
use Core\Database;

$db = App::container()->resolve(Database::class); //string z pełnym namespace'em klasy


$currentUserId = 2;

$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id']
])->findOrFail();

authorize($note['user_id'] === $currentUserId);

$db->query('DELETE FROM notes WHERE id = :id', [
    'id' => $_POST['id']
]);

header('location: /notes');
exit();
