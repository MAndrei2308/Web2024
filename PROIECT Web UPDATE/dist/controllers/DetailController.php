<?php
require_once '../models/Product.php';

class DetailController {
    public function getProductDetail($id) {
        $productModel = new Product();
        $product = $productModel->getProductById($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(["message" => "Product not found."]);
            exit;
        }

        return $product;
    }
}
?>
