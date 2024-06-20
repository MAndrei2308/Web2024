<?php
session_start();
require_once 'views/database.views';

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['user_id'])) {
    // Redirect către pagina de autentificare sau afișăm un mesaj către utilizator
    header('Location: login.views');
    exit;
}

// Conectăm la baza de date
$database = Database::getInstance();
$db = $database->getConnection();

// Selectăm toate produsele pentru a le afișa pe pagină
$sql = "SELECT * FROM products ORDER BY country";
$allProducts = $db->query($sql);

$productsByCountry = [];
while ($row = $allProducts->fetch(PDO::FETCH_ASSOC)) {
    $productsByCountry[$row['country']][] = $row;
}

// Funcție pentru a verifica dacă un produs este în lista de favorite
function isProductInFavorites($productId, $userId, $db) {
    $sqlCheckFavorite = "SELECT * FROM Favorites WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $db->prepare($sqlCheckFavorite);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/Conectat_CategoryDesign.css">
    <title>Category</title>
</head>

<body>
<header>
    <!-- Codul pentru header -->
</header>

<section class="souvenirs" id="souvenirs">
    <h1 class="heading"><span class="heading__highlight">Souvenir</span> Products</h1>

    <!-- Afișăm produsele împărțite pe țări -->
    <?php foreach ($productsByCountry as $country => $products): ?>
        <h2 class="country" id="<?php echo strtolower($country); ?>"><?php echo $country; ?></h2>
        <div class="souvenirs__box-container">
            <?php foreach ($products as $product): ?>
                <div class="souvenirs__box">
                    <!-- Verificăm dacă produsul este în favorite -->
                    <?php
                    $isFavorite = isProductInFavorites($product['id'], $_SESSION['user_id'], $db);
                    ?>
                    <a href="favorite_handler.php?action=<?php echo $isFavorite ? 'remove' : 'add'; ?>&product_id=<?php echo $product['id']; ?>">
                        <span class="heart-icon<?php echo $isFavorite ? '-red' : ''; ?>"></span>
                    </a>

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
    <!-- Codul pentru footer -->
</footer>
</body>

</html>
