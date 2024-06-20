<?php
require_once 'Database.php';

class Favorite {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addFavorite($userId, $productId) {
        try {
            $sql = "INSERT INTO Favorites (user_id, product_id) VALUES (:user_id, :product_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function getUserFavorites($userId) {
        try {
            $sql = "SELECT p.id, p.name, p.country, p.image FROM Favorites f JOIN Products p ON f.product_id = p.id WHERE f.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function removeFavorite($userId, $productId) {
        try {
            $sql = "DELETE FROM Favorites WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function isFavorite($userId, $productId) {
        try {
            $sql = "SELECT * FROM Favorites WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
