<?php
require_once '../controllers/ProductFilterController.php';

$productFilterController = new ProductFilterController();
$products = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $products = $productFilterController->filterProducts();
    if (is_string($products)) {
        $message = $products;
        $products = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Products</title>
    <link rel="stylesheet" href="../css/CategoryDesign.css">
</head>
<body>
<header>
    <div class="logo"><img src="../../img/Logo.png" alt="logo">Souvenirs<span>.</span></div>
    <input type="checkbox" id="toggler" class="toggler">
    <label for="toggler" class="toggler-icon">☰</label>
    <nav class="navbar">
        <ul class="navbar__links">
            <li class="navbar__links__item--link"><a href="PaginaPrincipala.php">Home</a></li>
            <li class="navbar__links__item--link"><a href="VirtualMap.php">Virtual Map</a></li>
            <li class="navbar__links__item--link"><a href="Category.php">Category</a></li>
        </ul>
    </nav>
    <div class="navbar__buttons">
        <a href="Login.php" class="navbar__buttons--button">Login</a>
        <a href="SignUp.php" class="navbar__buttons--button">Sign Up</a>
    </div>
</header>

<section class="souvenirs" id="souvenirs">
    <h1 class="heading"><span class="heading__highlight">Filtered</span> Products</h1>

    <?php if ($message) echo '<span class="message">' . $message . '</span>'; ?>

    <div class="souvenirs__box-container">
        <?php if(empty($products)){?>
            <h1 class="message-heading"> No products found !! </h1>
        <?php }
        foreach ($products as $product): ?>
            <div class="souvenirs__box" onclick="location.href='ProductDetail.php?id=<?php echo htmlspecialchars($product['id']); ?>'">
                
                <div class="souvenirs__image">
                    <img src="uploaded_img/<?php echo $product['image']; ?>" alt="souvenir">
                </div>
                <div class="souvenirs__content">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<footer class="footer">
    <div class="footer__content">
        <div class="footer__column">
            <h3>Contact</h3>
            <p>Adress: Street General Berthelot, Number 16, RO-700483 - Iaşi</p>
            <p>Email: contact@souvenirs.com</p>
            <p>Phone: 0232 20 1090; Fax: 0232 20 1490</p>
            <p>Social media</p>
            <div class="social-icons">
                <a href="#" target="_blank"><img src="../../img/facebook.png" alt="Facebook"></a>
                <a href="#" target="_blank"><img src="../../img/instagram.png" alt="Instagram"></a>
                <a href="#" target="_blank"><img src="../../img/tiktok.png" alt="TikTok"></a>
                <a href="#" target="_blank"><img src="../../img/twitter.png" alt="Twitter"></a>
            </div>
        </div>
        <div class="footer__column">
            <h3>Useful Links</h3>
            <div class="spacer"></div>
            <ul>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Privacy and Cookies Statement</a></li>
                <li><a href="AboutUs.php">About us</a></li>
                <li><a href="Help.php">Help</a></li>
            </ul>
        </div>
    </div>
    <div class="footer__copyright">
        <p>&copy; 2024 Souvenirs. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
