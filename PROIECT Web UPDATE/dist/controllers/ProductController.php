<?php
require_once '../models/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function addProduct() {
        if (isset($_POST['add_product'])) {
            $name = $_POST['product_name'];
            $country = $_POST['product_country'];
            $image = $_FILES['product_image']['name'];
            $tmp_name = $_FILES['product_image']['tmp_name'];
            $image_folder = '../uploaded_img/' . $image;

            if (empty($name) || empty($country) || empty($image)) {
                return 'Please fill out all fields';
            } else {
                if ($this->productModel->addProduct($name, $country, $image)) {
                    move_uploaded_file($tmp_name, $image_folder);
                    return 'New product added successfully';
                } else {
                    return 'Could not add the product';
                }
            }
        }
    }

    public function updateProduct($id) {
        if (isset($_POST['update_product'])) {
            $name = $_POST['product_name'];
            $country = $_POST['product_country'];
            $image = $_FILES['product_image']['name'];
            $tmp_name = $_FILES['product_image']['tmp_name'];
            $image_folder = '../uploaded_img/' . $image;

            if (empty($name) || empty($country) || empty($image)) {
                return 'Please fill out all fields';
            } else {
                if ($this->productModel->updateProduct($id, $name, $country, $image)) {
                    move_uploaded_file($tmp_name, $image_folder);
                    return 'Product updated successfully';
                } else {
                    return 'Could not update the product';
                }
            }
        }
    }

    public function deleteProduct($id) {
        if ($this->productModel->deleteProduct($id)) {
            return 'Product deleted successfully';
        } else {
            return 'Could not delete the product';
        }
    }

    public function getProduct($id) {
        return $this->productModel->getProductById($id);
    }

    public function getAllProducts() {
        return $this->productModel->getAllProducts();
    }
}
?>
