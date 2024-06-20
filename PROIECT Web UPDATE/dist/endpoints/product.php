<?php
require_once 'controllers/ProductController.php';

header('Content-Type: application/json');
$productController = new ProductController();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$response = [];

switch($requestMethod) {
    case 'POST':
        // Handle adding a product
        if (isset($_POST['add_product'])) {
            $response['message'] = $productController->addProduct();
        } elseif (isset($_POST['update_product'])) {
            $id = $_POST['id'];
            $response['message'] = $productController->updateProduct($id);
        }
        break;

    case 'GET':
        // Handle fetching products
        if (isset($_GET['id'])) {
            $response = $productController->getProduct($_GET['id']);
        } else {
            $response = $productController->getAllProducts();
        }
        break;

    case 'DELETE':
        // Handle deleting a product
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (isset($_DELETE['id'])) {
            $response['message'] = $productController->deleteProduct($_DELETE['id']);
        }
        break;

    default:
        $response['message'] = 'Invalid Request Method';
        break;
}

echo json_encode($response);
?>
