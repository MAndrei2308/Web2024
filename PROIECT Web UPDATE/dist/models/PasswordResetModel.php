<?php
class PasswordResetModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function storeResetToken($user_id, $token, $expiry_time) {
        $query = $this->conn->prepare("INSERT INTO password_resets (user_id, token, token_expiry) VALUES (:user_id, :token, :token_expiry)");
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':token', $token, PDO::PARAM_STR);
        $query->bindParam(':token_expiry', $expiry_time, PDO::PARAM_STR);
        $query->execute();
    }

    public function getResetRequestByToken($token) {
        $query = $this->conn->prepare("SELECT * FROM password_resets WHERE token = :token");
        $query->bindParam(':token', $token, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteResetRequest($id) {
        $query = $this->conn->prepare("DELETE FROM password_resets WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }
}
?>
