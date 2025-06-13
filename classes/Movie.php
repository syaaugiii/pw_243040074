<?php
require_once __DIR__ . '/../config/database.php';

class Movie {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function create($user_id, $title, $youtube_url) {
        $query = "INSERT INTO movies (user_id, title, youtube_url) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id, $title, $youtube_url]);
    }
    
    public function getAll() {
        $query = "SELECT m.*, u.username FROM movies m JOIN users u ON m.user_id = u.id ORDER BY m.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByUserId($user_id) {
        $query = "SELECT * FROM movies WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $query = "SELECT m.*, u.username FROM movies m JOIN users u ON m.user_id = u.id WHERE m.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function update($id, $title, $youtube_url) {
        $query = "UPDATE movies SET title = ?, youtube_url = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$title, $youtube_url, $id]);
    }
    
    public function delete($id) {
        $query = "DELETE FROM movies WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    
    public function getYouTubeId($url) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}
?>