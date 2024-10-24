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
}
