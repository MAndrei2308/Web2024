<?php
session_start();
require_once '../controllers/DetailController.php';


// Verificăm dacă există un id de produs în parametrii GET
if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit;
}

// Inițializăm controller-ii
$detailController = new DetailController();


// Preluăm detalii despre produs și comentariile asociate
$product = $detailController->getProductDetail(intval($_GET['id']));


$countryCoordinates = [
    'Italy' => [41.87194, 12.56738],
    'Spain' => [40.463667, -3.74922],
    'France' => [46.603354, 1.888334],
    'Germany' => [51.165691, 10.451526],
    'Romania' => [45.943161, 24.96676]
];

$coordinates = isset($countryCoordinates[$product['country']]) ? $countryCoordinates[$product['country']] : [0, 0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="../css/ProductDetailDesign.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<div class="product-detail">
    <div class="product-image">
        <img src="uploaded_img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="product-info">
        <h1><?php echo $product['name']; ?></h1>
        <p>Period: <?php echo $product['period']; ?></p>
        <p>Receiver: <?php echo $product['receiver']; ?></p>
    </div>
    <div id="map"></div>
</div>


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

<script>
    var map = L.map('map').setView([<?php echo $coordinates[0]; ?>, <?php echo $coordinates[1]; ?>], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([<?php echo $coordinates[0]; ?>, <?php echo $coordinates[1]; ?>]).addTo(map)
        .bindPopup('<?php echo $product['country']; ?>')
        .openPopup();


</script>

</body>
</html>
