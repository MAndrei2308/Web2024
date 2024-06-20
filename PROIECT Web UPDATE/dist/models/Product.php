<?php
require_once 'Database.php';
class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addProduct($name, $country, $period, $receiver, $image) {
        $stmt = $this->db->prepare("INSERT INTO products (name, country, period, receiver, image) VALUES (:name, :country, :period, :receiver, :image)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':period', $period);
        $stmt->bindParam(':receiver', $receiver);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function updateProduct($id, $name, $country, $period, $receiver, $image) {
        $stmt = $this->db->prepare("UPDATE products SET name = :name, country = :country, period = :period, receiver = :receiver, image = :image WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':period', $period);
        $stmt->bindParam(':receiver', $receiver);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
