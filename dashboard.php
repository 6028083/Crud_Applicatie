<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Post.php';
require_once 'classes/User.php';

$db = new Database();
$post = new Post($db);
$user = new User($db);

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Haal de posts op afhankelijk van de gebruikersrol
$posts = $post->getPostsByUserRole($_SESSION['user_id'], $_SESSION['role']);

// Verwijder post
if (isset($_POST['delete_post'])) {
    $post_id = $_POST['delete_post'];
    $post_user_id = $_POST['post_user_id'];

    if ($user->canDeletePost($_SESSION['role'], $post_user_id, $_SESSION['user_id'])) {
        $post->deletePost($post_id);
        header("Location: dashboard.php");
        exit();
    }
}
