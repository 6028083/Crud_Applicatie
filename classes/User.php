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

    public function changeUserRole($userId, $newRoleId)
    {
        $stmt = $this->db->getPdo()->prepare("UPDATE users SET role_id = ? WHERE id = ?");
        return $stmt->execute([$newRoleId, $userId]);
    }

    public function deleteUser($userId)
    {
        try {
            // Start een transactie
            $this->db->getPdo()->beginTransaction();

            // Verwijder eerst alle posts van de gebruiker
            $stmtDeletePosts = $this->db->getPdo()->prepare("DELETE FROM posts WHERE user_id = ?");
            $stmtDeletePosts->execute([$userId]);

            // Verwijder nu de gebruiker
            $stmtDeleteUser = $this->db->getPdo()->prepare("DELETE FROM users WHERE id = ?");
            $stmtDeleteUser->execute([$userId]);

            // Commit de transactie
            $this->db->getPdo()->commit();

            return true;
        } catch (\PDOException $e) {
            // Als er iets misgaat, rol de transactie terug
            $this->db->getPdo()->rollBack();
            error_log("Fout bij het verwijderen van gebruiker: " . $e->getMessage());
            return false;
        }
    }

    public function canDeletePost($userRole, $postUserId, $currentUserId)
    {
        return $userRole == 'Eigenaar' ||
            ($userRole == 'Admin' && $postUserId == $currentUserId) ||
            ($userRole == 'Gebruiker' && $postUserId == $currentUserId);
    }

    public function getAllRoles()
    {
        $stmt = $this->db->getPdo()->query("SELECT * FROM roles");
        return $stmt->fetchAll();
    }
}
