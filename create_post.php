<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Post.php';

$db = new Database();
$post = new Post($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($post->create($title, $content)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Er is een fout opgetreden bij het aanmaken van de post.";
    }
}
