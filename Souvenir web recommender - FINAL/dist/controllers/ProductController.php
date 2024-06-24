<?php
require_once '../models/Product.php';
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function addProduct() {
        if (isset($_POST['add_product'])) {
            $name = isset($_POST['product_name']) ? $_POST['product_name'] : null;
            $country = isset($_POST['product_country']) ? $_POST['product_country'] : null;
            $period = isset($_POST['period']) ? $_POST['period'] : null;
            $receiver = isset($_POST['receiver']) ? $_POST['receiver'] : null;
            $image = isset($_FILES['product_image']['name']) ? $_FILES['product_image']['name'] : null;
            $tmp_name = isset($_FILES['product_image']['tmp_name']) ? $_FILES['product_image']['tmp_name'] : null;
            $image_folder = '../views/uploaded_img/' . $image;

            if (empty($name) || empty($country) || empty($period) || empty($receiver) || empty($image)) {
                return 'Please fill out all fields';
            } else {
                if ($this->productModel->addProduct($name, $country, $period, $receiver, $image)) {
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
            $name = isset($_POST['product_name']) ? $_POST['product_name'] : null;
            $country = isset($_POST['product_country']) ? $_POST['product_country'] : null;
            $period = isset($_POST['period']) ? $_POST['period'] : null;
            $receiver = isset($_POST['receiver']) ? $_POST['receiver'] : null;
            $current_image = isset($_POST['current_image']) ? $_POST['current_image'] : null;

            $image = isset($_FILES['product_image']['name']) ? $_FILES['product_image']['name'] : null;
            $tmp_name = isset($_FILES['product_image']['tmp_name']) ? $_FILES['product_image']['tmp_name'] : null;
            $image_folder = '../views/uploaded_img/' . $image;

            // Check if new image was uploaded
            if (empty($image)) {
                // Use current image if no new image uploaded
                $image = $current_image;
            } else {
                // Upload new image
                move_uploaded_file($tmp_name, $image_folder);
            }

            if (empty($name) || empty($country) || empty($period) || empty($receiver)) {
                return 'Please fill out all fields';
            } else {
                if ($this->productModel->updateProduct($id, $name, $country, $period, $receiver, $image)) {
                    return 'Product updated successfully';
                } else {
                    return 'Could not update the product';
                }
            }
        }
    }

    public function deleteProduct($id) {
        if (isset($_GET['delete'])) {
            if ($this->productModel->deleteProduct($id)) {
                return 'Product deleted successfully';
            } else {
                return 'Could not delete the product';
            }
        }
    }

    public function getProducts() {
        return $this->productModel->getAllProducts();
    }

    public function getProduct($id) {
        return $this->productModel->getProductById($id);
    }

    public function exportProducts($format) {
        $products = $this->getProducts();

        switch ($format) {
            case 'html':
                $this->exportToHTML($products);
                break;
            case 'csv':
                $this->exportToCSV($products);
                break;
            case 'json':
                $this->exportToJSON($products);
                break;
            case 'xml':
                $this->exportToXML($products);
                break;
        }
    }

    private function exportToHTML($products) {
        header('Content-Type: text/html');
        echo '<html><body><table border="1">';
        echo '<tr><th>Product Name</th><th>Country</th><th>Period</th><th>Receiver</th></tr>';
        foreach ($products as $product) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($product['name']) . '</td>';
            echo '<td>' . htmlspecialchars($product['country']) . '</td>';
            echo '<td>' . htmlspecialchars($product['period']) . '</td>';
            echo '<td>' . htmlspecialchars($product['receiver']) . '</td>';
            echo '</tr>';
        }
        echo '</table></body></html>';
        exit();
    }

    private function exportToCSV($products) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=products.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Product Name', 'Country', 'Period', 'Receiver']);
        foreach ($products as $product) {
            fputcsv($output, $product);
        }
        fclose($output);
        exit();
    }

    private function exportToJSON($products) {
        header('Content-Type: application/json');
        echo json_encode($products);
        exit();
    }

    private function exportToXML($products) {
        header('Content-Type: text/xml');
        $xml = new SimpleXMLElement('<products/>');
        foreach ($products as $product) {
            $productNode = $xml->addChild('product');
            $productNode->addChild('name', htmlspecialchars($product['name']));
            $productNode->addChild('country', htmlspecialchars($product['country']));
            $productNode->addChild('period', htmlspecialchars($product['period']));
            $productNode->addChild('receiver', htmlspecialchars($product['receiver']));
        }
        echo $xml->asXML();
        exit();
    }

}

?>
