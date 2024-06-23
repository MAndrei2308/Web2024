<?php
require_once '../models/database.php';

$database = Database::getInstance();
$db = $database->getConnection();

$id = $_GET['edit'];

if(isset($_POST['update_product'])){
    $product_name = $_POST['product_name'];
    $product_country = $_POST['product_country'];
    $product_period = $_POST['period'];
    $product_receiver = $_POST['receiver'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'php/uploaded_img/'.$product_image;
    $current_image = $_POST['current_image'];

    if(empty($product_image)){
        $product_image = $current_image;
    } else {
        move_uploaded_file($product_image_tmp_name, $product_image_folder);
    }

    if(empty($product_name) || empty($product_country) || empty($product_period) || empty($product_receiver)){
        $message[] = 'Please fill out all fields!';
    } else {
        $update_data = $db->prepare("UPDATE products SET name = :name, country = :country, period = :period, receiver = :receiver, image = :image WHERE id = :id");
        $update_data->bindParam(':name', $product_name);
        $update_data->bindParam(':country', $product_country);
        $update_data->bindParam(':period', $product_period);
        $update_data->bindParam(':receiver', $product_receiver);
        $update_data->bindParam(':image', $product_image);
        $update_data->bindParam(':id', $id);

        if($update_data->execute()){
            header('location:AdminPage.php');
        } else {
            $message[] = 'Could not update the product!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/AdminDesign.css">
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $msg){
        echo '<span class="message">'.$msg.'</span>';
    }
}
?>

<div class="container">
    <div class="admin-product-form-container centered">
        <?php
        $select = $db->prepare("SELECT * FROM products WHERE id = :id");
        $select->bindParam(':id', $id);
        $select->execute();
        while($row = $select->fetch(PDO::FETCH_ASSOC)){ ?>
            <form action="" method="post" enctype="multipart/form-data">
                <h3 class="title">Update the Product</h3>
                <input type="text" class="box" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Enter the product name">
                <select name="product_country" class="box">
                    <option value="Italy" <?php if($row['country'] == 'Italy') echo 'selected'; ?>>Italy</option>
                    <option value="Spain" <?php if($row['country'] == 'Spain') echo 'selected'; ?>>Spain</option>
                    <option value="France" <?php if($row['country'] == 'France') echo 'selected'; ?>>France</option>
                    <option value="Germany" <?php if($row['country'] == 'Germany') echo 'selected'; ?>>Germany</option>
                    <option value="Romania" <?php if($row['country'] == 'Romania') echo 'selected'; ?>>Romania</option>
                </select>
                <select id="period" name="period" class="box">
                    <option value="spring" <?php if($row['period'] == 'spring') echo 'selected'; ?>>Spring</option>
                    <option value="summer" <?php if($row['period'] == 'summer') echo 'selected'; ?>>Summer</option>
                    <option value="autumn" <?php if($row['period'] == 'autumn') echo 'selected'; ?>>Autumn</option>
                    <option value="winter" <?php if($row['period'] == 'winter') echo 'selected'; ?>>Winter</option>
                </select>
                <select id="receiver" name="receiver" class="box">
                    <option value="Infant" <?php if($row['receiver'] == 'Infant') echo 'selected'; ?>>Infant</option>
                    <option value="Toddler" <?php if($row['receiver'] == 'Toddler') echo 'selected'; ?>>Toddler</option>
                    <option value="Child" <?php if($row['receiver'] == 'Child') echo 'selected'; ?>>Child</option>
                    <option value="Adolescent" <?php if($row['receiver'] == 'Adolescent') echo 'selected'; ?>>Adolescent</option>
                    <option value="Adult" <?php if($row['receiver'] == 'Adult') echo 'selected'; ?>>Adult</option>
                    <option value="Elderly" <?php if($row['receiver'] == 'Elderly') echo 'selected'; ?>>Elderly</option>
                </select>
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($row['image']); ?>">
                <input type="file" class="box" name="product_image" accept="image/*">
                <input type="submit" value="Update Product" name="update_product" class="btn">

            </form>
        <?php } ?>
    </div>
</div>
</body>
</html>
