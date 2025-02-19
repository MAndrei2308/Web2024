<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/AboutUsDesign.css">
    <title>About Us</title>
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

            <a href="Login.php" class="navbar__buttons--button">Login</a>
            <a href="SignUp.php" class="navbar__buttons--button">Sign Up</a>

        </div>
    </header>
    <section class="about-us">
        <div class="about">
            <img src="../../img/aboutUs.jpg" class="pic" alt="about-us">
            <div class="text">
                <h2>About Us</h2>
                <h5> <span>Students: </span>Gabriela & Andrei</h5>
                <p>
                    Souvenirs is an innovative web application designed for explorers of Europe.
                    Our goal is to provide a personalized experience in choosing souvenirs,
                    reflecting the culture and traditions of each visited region.
                    We aim to connect travelers with the cultural essence of their destinations through souvenirs.
                    Our vision is for every journey to become a memorable story, enriched with meaningful objects.
                </p>
                <div class="data">
                    <a href="Help.php" class="hire">Help</a>
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