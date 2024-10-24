<?php
class User
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function login($username, $password)
    {
        $stmt = $this->db->getPdo()->prepare("SELECT users.*, roles.name as role_name FROM users JOIN roles ON users.role_id = roles.id WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role_name'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
    }

    public function getAllUsers()
    {
        $stmt = $this->db->getPdo()->query("SELECT users.*, roles.name as role_name FROM users JOIN roles ON users.role_id = roles.id");
        return $stmt->fetchAll();
    }
}
