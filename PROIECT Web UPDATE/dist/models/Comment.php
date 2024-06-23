<?php
require_once 'database.php';

class Comment {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getCommentsByProductId($productId) {
        $stmt = $this->db->prepare("
        SELECT c.*, u.username 
        FROM comments c 
        JOIN users u ON c.user_id = u.user_id 
        WHERE c.product_id = ? 
        ORDER BY c.created_at DESC
        ");
        $stmt->bindParam(1, $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment($productId, $userId, $comment) {
        $stmt = $this->db->prepare("INSERT INTO comments (product_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $productId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->bindParam(3, $comment, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function deleteComment($commentId, $userId) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE comment_id = ? AND user_id = ?");
        $stmt->bindParam(1, $commentId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUsernameById($userId) {
        $stmt = $this->db->prepare("SELECT username FROM users WHERE user_id = ?");
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}
?>
