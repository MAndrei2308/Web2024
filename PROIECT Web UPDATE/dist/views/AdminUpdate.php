<?php

@include '../models/database.php';

$database = Database::getInstance();
$db = $database->getConnection();

$id = $_GET['edit'];

if(isset($_POST['update_product'])){
    $product_name = $_POST['product_name'];
    $product_country = $_POST['product_country'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image;

    if(empty($product_name) || empty($product_country) || empty($product_image)){
        $message[] = 'please fill out all fields!';
    } else {
        $update_data = $db->prepare("UPDATE products SET name = :name, country = :country, image = :image WHERE id = :id");
        $update_data->bindParam(':name', $product_name);
        $update_data->bindParam(':country', $product_country);
        $update_data->bindParam(':image', $product_image);
        $update_data->bindParam(':id', $id);

        if($update_data->execute()){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            header('location:AdminPage.views');
        } else {
            $message[] = 'please fill out all fields!';
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
                <h3 class="title">update the product</h3>
                <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="enter the product name">
                <select name="product_country" class="box">
                    <option value="Italy" <?php if($row['country'] == 'Italy') echo 'selected'; ?>>Italy</option>
                    <option value="Spain" <?php if($row['country'] == 'Spain') echo 'selected'; ?>>Spain</option>
                    <option value="France" <?php if($row['country'] == 'France') echo 'selected'; ?>>France</option>
                    <option value="Germany" <?php if($row['country'] == 'Germany') echo 'selected'; ?>>Germany</option>
                    <option value="Romania" <?php if($row['country'] == 'Romania') echo 'selected'; ?>>Romania</option>
                </select>
                <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
                <input type="submit" value="update product" name="update_product" class="btn">
                <a href="AdminPage.php" class="btn">go back!</a>
            </form>
        <?php } ?>
    </div>
</div>

</body>
</html>
