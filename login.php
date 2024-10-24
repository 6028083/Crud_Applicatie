<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';

$db = new Database();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->login($username, $password)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Ongeldige gebruikersnaam of wachtwoord";
    }
}
