<?php
require_once '../controllers/ProductController.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit();
} else {
    if($_SESSION['role']!=='ADMIN') {
        header('Location: ../controllers/HomeController.php');
        exit();
    }
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

    <script>
        window.addEventListener("beforeunload", function (event) {
            // Send a beacon to logout.php when the page is unloaded
            navigator.sendBeacon("../controllers/LogoutController.php");
        });
    </script>
</head>
<body>
<?php if ($message) echo '<span class="message">' . $message . '</span>'; ?>
<div class="container">
    <div class="admin-product-form-container">
        <?php if (isset($_GET['edit'])): ?>
        <?php $product = $productController->getProduct($_GET['edit']); ?>
        <form action="AdminPage.php?edit=<?php echo $_GET['edit']; ?>" method="post" enctype="multipart/form-data">
            <h3>Update the Product</h3>
            <input type="text" placeholder="Enter product name" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>" class="box">
            <select name="product_country" class="box">
                <option value="Italy" <?php if ($product['country'] == 'Italy') echo 'selected'; ?>>Italy</option>
                <option value="Spain" <?php if ($product['country'] == 'Spain') echo 'selected'; ?>>Spain</option>
                <option value="France" <?php if ($product['country'] == 'France') echo 'selected'; ?>>France</option>
                <option value="Germany" <?php if ($product['country'] == 'Germany') echo 'selected'; ?>>Germany</option>
                <option value="Romania" <?php if ($product['country'] == 'Romania') echo 'selected'; ?>>Romania</option>
            </select>
            <select id="period" name="period" class="box">
                <option value="spring" <?php if ($product['period'] == 'spring') echo 'selected'; ?>>Spring</option>
                <option value="summer" <?php if ($product['period'] == 'summer') echo 'selected'; ?>>Summer</option>
                <option value="autumn" <?php if ($product['period'] == 'autumn') echo 'selected'; ?>>Autumn</option>
                <option value="winter" <?php if ($product['period'] == 'winter') echo 'selected'; ?>>Winter</option>
            </select>
            <select id="receiver" name="receiver" class="box">
                <option value="Infant" <?php if ($product['receiver'] == 'Infant') echo 'selected'; ?>>Infant</option>
                <option value="Toddler" <?php if ($product['receiver'] == 'Toddler') echo 'selected'; ?>>Toddler</option>
                <option value="Child" <?php if ($product['receiver'] == 'Child') echo 'selected'; ?>>Child</option>
                <option value="Adolescent" <?php if ($product['receiver'] == 'Adolescent') echo 'selected'; ?>>Adolescent</option>
                <option value="Adult" <?php if ($product['receiver'] == 'Adult') echo 'selected'; ?>>Adult</option>
                <option value="Elderly" <?php if ($product['receiver'] == 'Elderly') echo 'selected'; ?>>Elderly</option>
            </select>
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($product['image']); ?>">
            <input type="file" accept="image/*" name="product_image" class="box">
            <input type="submit" class="btn" name="update_product" value="Update Product">
        </form>
        <?php else: ?>
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
        <?php endif; ?>
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
                        <a href="AdminPage.php?edit=<?php echo $product['id']; ?>" class="btn">Edit</a>
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
