<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserByEmail($email) {
        $query = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($user_id, $new_pass_hash) {
        $query = $this->conn->prepare("UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id");
        $query->bindParam(':password_hash', $new_pass_hash, PDO::PARAM_STR);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
    }
}
?>
