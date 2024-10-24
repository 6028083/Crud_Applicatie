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
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Blog</title>
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
        <div class="page-header">
            <h1>Blog Posts</h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="create_post.php" class="btn btn-primary">Nieuwe Post Aanmaken</a>
            <?php endif; ?>
        </div>

        <div class="post-grid">
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <img src="https://picsum.photos/300/200?random=<?php echo $post['id']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                    <a href="view_post.php?id=<?php echo $post['id']; ?>">Lees meer</a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" <?php echo $i === $page ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </main>
</body>

</html>