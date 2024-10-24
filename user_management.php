<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';

$db = new Database();
$user = new User($db);

// Controleer of de gebruiker is ingelogd en de juiste rol heeft
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'Eigenaar' && $_SESSION['role'] != 'Admin')) {
    header("Location: index.php");
    exit();
}

$users = $user->getAllUsers();
$roles = $user->getAllRoles();  // Haal alle rollen op

// Verwijder gebruiker
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = $_POST['delete_user'];  // Gewijzigd van $_POST['user_id'] naar $_POST['delete_user']
    if ($user->deleteUser($userId)) {
        $successMessage = "Gebruiker succesvol verwijderd.";
    } else {
        $errorMessage = "Er is een fout opgetreden bij het verwijderen van de gebruiker.";
    }
}

// Wijzig gebruikersrol
if (isset($_POST['change_role']) && $_SESSION['role'] == 'Eigenaar') {
    $userId = $_POST['user_id'];
    $newRoleId = $_POST['new_role'];

    $user->changeUserRole($userId, $newRoleId);
    header("Location: user_management.php");
    exit();
}
