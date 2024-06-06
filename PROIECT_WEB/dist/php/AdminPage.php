<?php

@include 'database.php';

// Inițializarea conexiunii la baza de date
$database = new Database();
$db = $database->getConnection();

if(isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_country = $_POST['product_country'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image;

    if(empty($product_name) || empty($product_country) || empty($product_image)){
        $message[] = 'please fill out all fields';
    } else {
        $insert = $db->prepare("INSERT INTO products(name, country, image) VALUES(:name, :country, :image)");
        $insert->bindParam(':name', $product_name);
        $insert->bindParam(':country', $product_country);
        $insert->bindParam(':image', $product_image);

        if($insert->execute()){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'new product added successfully';
        } else {
            $message[] = 'could not add the product';
        }
    }
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete = $db->prepare("DELETE FROM products WHERE id = :id");
    $delete->bindParam(':id', $id);
    $delete->execute();
    header('location:AdminPage.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    <div class="admin-product-form-container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <h3>add a new product</h3>
            <input type="text" placeholder="enter product name" name="product_name" class="box">
            <select name="product_country" class="box">
                <option value="" disabled selected>select country</option>
                <option value="Italy">Italy</option>
                <option value="Spain">Spain</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="Romania">Romania</option>
            </select>
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
            <input type="submit" class="btn" name="add_product" value="add product">
        </form>
    </div>

    <div class="product-display">
        <table class="product-display-table">
            <thead>
            <tr>
                <th>product image</th>
                <th>product name</th>
                <th>product country</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $select = $db->query("SELECT * FROM products");
            while($row = $select->fetch(PDO::FETCH_ASSOC)){ ?>
                <tr>
                    <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['country']; ?></td>
                    <td>
                        <a href="AdminUpdate.php?edit=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-edit"></i> edit </a>
                        <a href="AdminPage.php?delete=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-trash"></i> delete </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
