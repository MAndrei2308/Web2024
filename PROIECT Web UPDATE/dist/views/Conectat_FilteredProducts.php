<?php
session_start();
require_once '../controllers/ProductFilterController.php';
require_once '../controllers/FavoriteController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$productFilterController = new ProductFilterController();
$favoriteController = new FavoriteController();
$userId = $_SESSION['user_id'];

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
    <link rel="stylesheet" href="../css/Conectat_CategoryDesign.css">
</head>
<body>
<header>
    <div class="logo"><img src="../../img/Logo.png" alt="logo">Souvenirs<span>.</span></div>
    <input type="checkbox" id="toggler" class="toggler">
    <label for="toggler" class="toggler-icon">☰</label>

    <nav class="navbar">
        <ul class="navbar__links">
            <li class="navbar__links__item--link"><a href="Conectat_Home.php">Home</a></li>
            <li class="navbar__links__item--link"><a href="Conectat_VirtualMap.php">Virtual Map</a></li>
            <li class="navbar__links__item--link"><a href="Conectat_Category.php">Category</a></li>
        </ul>
    </nav>
    <div class="navbar__buttons">
        <input type="checkbox" id="user" class="user">
        <label for="user" class="user-icon"><a href="../controllers/ProfilController.php"><img src="../../img/profile-user.png" alt="profile"></a></label>
    </div>
</header>

<section class="souvenirs" id="souvenirs">
    <h1 class="heading"><span class="heading__highlight">Filtered</span> Products</h1>

    <?php if ($message) echo '<span class="message">' . $message . '</span>'; ?>

    <div class="souvenirs__box-container">
        <?php foreach ($products as $product): ?>
            <div class="souvenirs__box">
                <form action="../endpoints/handle_favorite.php" method="POST" class="favorite-form">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <button type="button" class="heart-checkbox" onclick="toggleFavorite(<?php echo htmlspecialchars($product['id']); ?>, this)">
                        <div class="heart-icon <?php echo $favoriteController->isFavorite($userId, $product['id']) ? 'heart-icon-red' : ''; ?>"></div>
                    </button>
                </form>
                <div class="souvenirs__image" onclick="location.href='ProductDetail.php?id=<?php echo htmlspecialchars($product['id']); ?>'">
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

<script>
    function toggleFavorite(productId, button) {
        var userId = <?php echo isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0; ?>;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../endpoints/handle_favorite.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var heartIcon = button.querySelector('.heart-icon');
                        // Toggle class based on isFavorite response
                        if (response.isFavorite) {
                            heartIcon.classList.add('heart-icon-red');
                        } else {
                            heartIcon.classList.remove('heart-icon-red');
                        }
                    } else {
                        console.error('Error: ' + response.message);
                    }
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        xhr.send("product_id=" + encodeURIComponent(productId) + "&user_id=" + encodeURIComponent(userId));
    }
</script>

</body>
</html>
