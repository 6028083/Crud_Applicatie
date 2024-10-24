<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Post.php';

$db = new Database();
$post = new Post($db);

// Paginering
$posts_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$total_posts = $post->getTotalPosts();
$total_pages = ceil($total_posts / $posts_per_page);

$posts = $post->getAllPosts($page, $posts_per_page);
