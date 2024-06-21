<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="css/FavoritePaginaDesign.css">
    <title>Favorite</title>
</head>

<body>
    <header>
        <div class="logo"><img src="../img/Logo.png" alt="logo">Souvenirs<span>.</span></div>
        <input type="checkbox" id="toggler" class="toggler">
        <label for="toggler" class="toggler-icon">☰</label>

        <nav class="navbar">
            <ul class="navbar__links">
                <li class="navbar__links__item--link"><a href="../../../../../../../xampp/htdocs/PROIECT%20Web%20UPDATE/dist/views/home.php">Home</a></li>
                <li class="navbar__links__item--link"><a href="../../../../../../../xampp/htdocs/PROIECT%20Web%20UPDATE/dist/views/virtualMap.php">Virtual Map</a></li>
                <li class="navbar__links__item--link"><a href="php/category.php">Category</a></li>
            </ul>
        </nav>
        <div class="navbar__buttons">

            <input type="checkbox" id="user" class="user">
            <label for="user" class="user-icon"><a href="../../../../../../../xampp/htdocs/PROIECT%20Web%20UPDATE/dist/views/profil.php"><img src="../img/profile-user.png" alt="profile">
                </a></label>

        </div>
    </header>


    <section class="souvenirs" id="souvenirs">
        <h1 class="heading"><img src="../img/iconheart-rose.png" alt="icon"><span class="heading__highlight">Favorite </span>
            Souvenirs</h1>

        <div class="souvenirs__box-container">
            <div class="souvenirs__box">

                <div class="souvenirs__image">
                    <img src="../img/souvenir1.jpg" alt="souvenir">
                </div>

                <div class="souvenirs__content">
                    <h3>Souvenir1</h3>
                    <h4>From: Italy</h4>
                    <img src="../img/recycle-bin.png" alt="bin">
                </div>
            </div>
            <div class="souvenirs__box">

                <div class="souvenirs__image">
                    <img src="../img/souvenir2.jpg" alt="souvenir">
                </div>

                <div class="souvenirs__content">
                    <h3>Souvenir2</h3>
                    <h4>From: Italy</h4>
                    <img src="../img/recycle-bin.png" alt="bin">
                </div>
            </div>

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
                    <li><a href="../../../../../../../xampp/htdocs/PROIECT%20Web%20UPDATE/dist/views/aboutUs.php">About us</a></li>
                    <li><a href="../../../../../../../xampp/htdocs/PROIECT%20Web%20UPDATE/dist/views/help.php">Help</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__copyright">
            <p>&copy; 2024 Souvenirs. All rights reserved.</p>
        </div>
    </footer>
</body>



</html>