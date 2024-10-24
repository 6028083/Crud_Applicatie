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
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Post Aanmaken</title>
    <link rel="stylesheet" href="styles/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="header-content">
            <h1>Mijn Blog</h1>
            <nav>
                <a href="index.php">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <?php if ($_SESSION['role'] == 'Eigenaar' || $_SESSION['role'] == 'Admin'): ?>
                        <a href="user_management.php">Gebruikers</a>
                    <?php endif; ?>
                    <div class="user-dropdown">
                        <div class="user-info">
                            <img src="https://picsum.photos/40" alt="Profielfoto" class="avatar">
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </div>
                        <div class="user-dropdown-content">
                            <a href="logout.php">Uitloggen</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php">Inloggen</a>
                    <a href="register.php">Registreren</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <h1>Nieuwe Post Aanmaken</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" class="create-post-form">
            <div class="form-group">
                <label for="title">Titel</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Inhoud</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Aanmaken</button>
        </form>
    </main>
</body>

</html>