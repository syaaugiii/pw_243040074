<?php
session_start();
require_once __DIR__ . '/../config/database.php';

class Auth
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function register($username, $email, $password, $role = 'user')
    {
        // Check if email already exists
        $checkQuery = "SELECT id FROM users WHERE email = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->execute([$email]);

        if ($checkStmt->fetch()) {
            return false; // Email already exists
        }

        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([$username, $email, $hashed_password, $role]);
    }


    public function login($email, $password)
    {
        $query = "SELECT id, username, email, password, role FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            header('Location: ../login.php');
            exit;
        }
    }

    public function requireAdmin()
    {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            header('Location: ../admin');
            exit;
        }
    }
}
