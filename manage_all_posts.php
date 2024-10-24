<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isAdmin($pdo, $_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id");
$posts = $stmt->fetchAll();
