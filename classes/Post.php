<?php
class Post
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllPosts($page, $postsPerPage)
    {
        $offset = ($page - 1) * $postsPerPage;
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalPosts()
    {
        return $this->db->getPdo()->query("SELECT COUNT(*) FROM posts")->fetchColumn();
    }

    public function getPostById($postId)
    {
        $stmt = $this->db->getPdo()->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetch();
    }
}
