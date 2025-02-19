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
    <link rel="stylesheet" href="../css/Conectat_HomeDesign.css">
    <title>Home</title>
</head>

<body>
    <header>
        <div class="logo"><img src="../../img/Logo.png" alt="logo">Souvenirs<span>.</span></div>

        <input type="checkbox" id="toggler" class="toggler">
        <label for="toggler" class="toggler-icon">☰</label>

        <nav class="navbar">
            <ul class="navbar__links">
                <li class="navbar__links__item--link"><a href="../controllers/HomeController.php">Home</a></li>
                <li class="navbar__links__item--link"><a href="../controllers/VirtualMapController.php">Virtual Map</a></li>
                <li class="navbar__links__item--link"><a href="../controllers/CategoryController.php">Category</a></li>
            </ul>
        </nav>
        <div class="navbar__buttons">

            <input type="checkbox" id="user" class="user">
            <label for="user" class="user-icon"><a href="../controllers/ProfilController.php"><img
                            src="../../img/profile-user.png" alt="profile"></a></label>

        </div>
    </header>



    <div class="container">
        <img src="../../img/Principal.jpg" class="container__image" alt="imagineahome">
        <div class="container__overlay">
            <form class="container__search-bar" action="Conectat_FilteredProducts.php" method="POST">
                <div class="container__search-bar__field">
                    <label for="country">Country:</label>
                    <select id="country" name="country">
                        <option value="">Select a country...</option>
                        <option value="Italy">Italy</option>
                        <option value="Spain">Spain</option>
                        <option value="France">France</option>
                        <option value="Germany">Germany</option>
                        <option value="Romania">Romania</option>
                    </select>
                </div>
                <div class="container__search-bar__field">
                    <label for="period">Period:</label>
                    <select id="period" name="period">
                        <option value="">Select a period...</option>
                        <option value="spring">Spring</option>
                        <option value="summer">Summer</option>
                        <option value="autumn">Autumn</option>
                        <option value="winter">Winter</option>
                    </select>
                </div>
                <div class="container__search-bar__field">
                    <label for="receiver">Receiver:</label>
                    <select id="receiver" name="receiver">
                        <option value="">Select a receiver...</option>
                        <option value="Child">Child</option>
                        <option value="Adolescent">Adolescent</option>
                        <option value="Adult">Adult</option>
                        <option value="Elderly">Elderly</option>
                    </select>
                </div>
                <button type="submit" class="container__search-bar__button">Search</button>
            </form>
        </div>
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
                    <li><a href="../controllers/AboutUsController.php">About us</a></li>
                    <li><a href="../controllers/HelpController.php">Help</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__copyright">
            <p>&copy; 2024 Souvenirs. All rights reserved.</p>
        </div>
    </footer>

</body>


</html>