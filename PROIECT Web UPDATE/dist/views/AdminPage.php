<?php
require_once '../controllers/ProductController.php';

$productController = new ProductController();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $message = $productController->addProduct();
    } elseif (isset($_POST['update_product'])) {
        $id = $_GET['edit'];
        $message = $productController->updateProduct($id);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $message = $productController->deleteProduct($id);
}

$products = $productController->getAllProducts();
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
        <?php if (isset($_GET['edit'])): ?>
            <?php $product = $productController->getProduct($_GET['edit']); ?>
            <form action="AdminPage.php?edit=<?php echo $_GET['edit']; ?>" method="post" enctype="multipart/form-data">
                <h3>Update the Product</h3>
                <input type="text" placeholder="Enter product name" name="product_name" value="<?php echo $product['name']; ?>" class="box">
                <select name="product_country" class="box">
                    <option value="Italy" <?php if ($product['country'] == 'Italy') echo 'selected'; ?>>Italy</option>
                    <option value="Spain" <?php if ($product['country'] == 'Spain') echo 'selected'; ?>>Spain</option>
                    <option value="France" <?php if ($product['country'] == 'France') echo 'selected'; ?>>France</option>
                    <option value="Germany" <?php if ($product['country'] == 'Germany') echo 'selected'; ?>>Germany</option>
                    <option value="Romania" <?php if ($product['country'] == 'Romania') echo 'selected'; ?>>Romania</option>
                </select>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="update_product" value="Update Product">
                <a href="AdminPage.php" class="btn">Cancel</a>
            </form>
        <?php else: ?>
            <form action="AdminPage.php" method="post" enctype="multipart/form-data">
                <h3>Add a New Product</h3>
                <input type="text" placeholder="Enter product name" name="product_name" class="box">
                <select name="product_country" class="box">
                    <option value="" disabled selected>Select country</option>
                    <option value="Italy">Italy</option>
                    <option value="Spain">Spain</option>
                    <option value="France">France</option>
                    <option value="Germany">Germany</option>
                    <option value="Romania">Romania</option>
                </select>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="add_product" value="Add Product">
            </form>
        <?php endif; ?>
    </div>

    <div class="product-display">
        <table class="product-display-table">
            <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Country</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img src="uploaded_img/<?php echo $product['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['country']; ?></td>
                    <td>
                        <a href="AdminPage.php?edit=<?php echo $product['id']; ?>" class="btn"><i class="fas fa-edit"></i> Edit </a>
                        <a href="AdminPage.php?delete=<?php echo $product['id']; ?>" class="btn"><i class="fas fa-trash"></i> Delete </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
