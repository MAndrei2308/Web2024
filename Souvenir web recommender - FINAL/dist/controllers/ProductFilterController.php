<?php
require_once '../models/Product.php';

class ProductFilterController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function filterProducts() {
        $country = isset($_POST['country']) ? $_POST['country'] : null;
        $period = isset($_POST['period']) ? $_POST['period'] : null;
        $receiver = isset($_POST['receiver']) ? $_POST['receiver'] : null;

        // if (empty($country) && empty($period) && empty($receiver)) {
        //     return 'Please select any filter';
        // } else {
            return $this->productModel->getFilteredProducts($country, $period, $receiver);
        // }
    }
}
?>
