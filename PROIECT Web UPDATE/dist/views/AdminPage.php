<?php
require_once '../controllers/ProductController.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit();
}

$productController = new ProductController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $message = $productController->addProduct();
    } elseif (isset($_POST['update_product'])) {
        $id = $_GET['edit'];
        $message = $productController->updateProduct($id);
    } elseif (isset($_POST['export_html'])) {
        $productController->exportProducts('html');
    } elseif (isset($_POST['export_csv'])) {
        $productController->exportProducts('csv');
    } elseif (isset($_POST['export_json'])) {
        $productController->exportProducts('json');
    } elseif (isset($_POST['export_xml'])) {
        $productController->exportProducts('xml');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $message = $productController->deleteProduct($id);
}

$products = $productController->getProducts();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../css/AdminDesign.css">
</head>
<body>
<?php if ($message) echo '<span class="message">' . $message . '</span>'; ?>
<div class="container">
    <div class="admin-product-form-container">
        <form action="AdminPage.php" method="post" enctype="multipart/form-data">
            <h3>Add a New Product</h3>
            <input type="text" placeholder="Enter product name" name="product_name" class="box">
            <select name="product_country" class="box">
                <option value="Italy">Italy</option>
                <option value="Spain">Spain</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="Romania">Romania</option>
            </select>
            <select id="period" name="period" class="box">
                <option value="spring">Spring</option>
                <option value="summer">Summer</option>
                <option value="autumn">Autumn</option>
                <option value="winter">Winter</option>
            </select>
            <select id="receiver" name="receiver" class="box">
                <option value="Infant">Infant</option>
                <option value="Toddler">Toddler</option>
                <option value="Child">Child</option>
                <option value="Adolescent">Adolescent</option>
                <option value="Adult">Adult</option>
                <option value="Elderly">Elderly</option>
            </select>
            <input type="file" accept="image/*" name="product_image" class="box">
            <input type="submit" class="btn" name="add_product" value="Add Product">
        </form>
    </div>

    <div class="export-buttons-container">
        <form action="AdminPage.php" method="post" class="export-buttons">
            <button type="submit" name="export_html" class="btn">Export HTML</button>
            <button type="submit" name="export_csv" class="btn">Export CSV</button>
            <button type="submit" name="export_json" class="btn">Export JSON</button>
            <button type="submit" name="export_xml" class="btn">Export XML</button>
        </form>
    </div>

    <div class="product-display-table">
        <table>
            <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Country</th>
                <th>Period</th>
                <th>Receiver</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img src="uploaded_img/<?php echo $product['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['country']; ?></td>
                    <td><?php echo $product['period']; ?></td>
                    <td><?php echo $product['receiver']; ?></td>
                    <td>
                        <a href="AdminUpdate.php?edit=<?php echo $product['id']; ?>" class="btn">Edit</a>
                        <a href="AdminPage.php?delete=<?php echo $product['id']; ?>" class="btn">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
