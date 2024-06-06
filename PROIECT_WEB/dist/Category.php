<?php

require_once 'php/database.php';
$database = new Database();
$db = $database->getConnection();

$sql = "SELECT * FROM products ORDER BY country";
$all_product = $db->query($sql);

$products_by_country = [];
while ($row = $all_product->fetch(PDO::FETCH_ASSOC)) {
    $products_by_country[$row['country']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/CategoryDesign.css">
    <title>Category</title>
</head>

<body>
<header>
    <div class="logo"><img src="../img/Logo.png" alt="logo">Souvenirs<span>.</span></div>
    <input type="checkbox" id="toggler" class="toggler">
    <label for="toggler" class="toggler-icon">☰</label>

    <nav class="navbar">
        <ul class="navbar__links">
            <li class="navbar__links__item--link"><a href="PaginaPrincipala.html">Home</a></li>
            <li class="navbar__links__item--link"><a href="VirtualMap.html">Virtual Map</a></li>
            <li class="navbar__links__item--link"><a href="Category.html">Category</a></li>
        </ul>
    </nav>
    <div class="navbar__buttons">
        <a href="Login.html" class="navbar__buttons--button">Login</a>
        <a href="SignUp.html" class="navbar__buttons--button">Sign Up</a>
    </div>
</header>

<section class="souvenirs" id="souvenirs">
    <h1 class="heading"><span class="heading__highlight">Souvenir</span> Products</h1>

    <nav class="toc">
        <h2>Cuprins</h2>
        <ul>
            <?php foreach (array_keys($products_by_country) as $country): ?>
                <li><a href="#<?php echo strtolower($country); ?>"><?php echo $country; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php foreach ($products_by_country as $country => $products): ?>
        <h2 class="country" id="<?php echo strtolower($country); ?>"><?php echo $country; ?></h2>
        <div class="souvenirs__box-container">
            <?php foreach ($products as $product): ?>
                <div class="souvenirs__box">

                    <div <?php echo $product['id']; ?>" class="heart-label">
                        <span class="heart-icon"></span>
                    </div>

                    <div class="souvenirs__image">
                        <img src="php/uploaded_img/<?php echo $product['image']; ?>" alt="souvenir">
                    </div>

                    <div class="souvenirs__content">
                        <h3><?php echo $product['name']; ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
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
                <a href="#" target="_blank"><img src="../img/facebook.png" alt="Facebook"></a>
                <a href="#" target="_blank"><img src="../img/instagram.png" alt="Instagram"></a>
                <a href="#" target="_blank"><img src="../img/tiktok.png" alt="TikTok"></a>
                <a href="#" target="_blank"><img src="../img/twitter.png" alt="Twitter"></a>
            </div>
        </div>
        <div class="footer__column">
            <h3>Useful Links</h3>
            <div class="spacer"></div>
            <ul>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Privacy and Cookies Statement</a></li>
                <li><a href="AboutUs.html">About us</a></li>
                <li><a href="Help.html">Help</a></li>
            </ul>
        </div>
    </div>
    <div class="footer__copyright">
        <p>&copy; 2024 Souvenirs. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
