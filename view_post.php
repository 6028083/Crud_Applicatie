<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Post.php';

$db = new Database();
$post = new Post($db);

// Controleer of er een post ID is meegegeven
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$post_id = $_GET['id'];
$post_data = $post->getPostById($post_id);

// Als de post niet bestaat, redirect naar de homepage
if (!$post_data) {
    header('Location: index.php');
    exit();
}
