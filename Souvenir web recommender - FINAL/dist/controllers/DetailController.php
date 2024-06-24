<?php
require_once '../models/Product.php';

class DetailController {
    public function getProductDetail($id) {
        $productModel = new Product();
        try {
            $product = $productModel->getProductById($id);

            if (!$product) {
                http_response_code(404);
                return ["message" => "Product not found."];
            }

            return $product;
        } catch (Exception $e) {
            http_response_code(500);
            return ["message" => "An error occurred while fetching product details."];
        }
    }
}

?>
