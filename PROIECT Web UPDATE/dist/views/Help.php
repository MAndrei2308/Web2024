<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/HelpDesign.css">
    <title>Help</title>
</head>

<body>
    <header>
        <div class="logo"><img src="../../img/Logo.png" alt="logo">Souvenirs<span>.</span></div>

        <input type="checkbox" id="toggler" class="toggler">
        <label for="toggler" class="toggler-icon">☰</label>

        <nav class="navbar">
            <ul class="navbar__links">
                <li class="navbar__links__item--link"><a href="../controllers/HomeController.php">Home</a></li>
                <li class="navbar__links__item--link"><a href="../controllers/HomeController.php">Virtual Map</a></li>
                <li class="navbar__links__item--link"><a href="../controllers/HomeController.php">Category</a></li>
            </ul>
        </nav>
        <div class="navbar__buttons">
            <a href="Login.php" class="navbar__buttons--button">Login</a>
            <a href="SignUp.php" class="navbar__buttons--button">Sign Up</a>

        </div>
    </header>

    <div class="container">
        <h1><img src="../../img/help.png" alt="help"> Help - Souvenirs</h1>
        <div class="help-content">
            <p>Welcome to the Help section of Souvenirs. Here you'll find information on how to use our platform and
                make the most out of your souvenir shopping experience.</p>
            <h2>What is Souvenirs?</h2>
            <p>Souvenirs is a web application designed to assist travelers in managing and recommending souvenirs for
                each region or country they visit. Whether you're planning a trip around the world or exploring a single
                region, Souvenirs is here to help you make the most out of your souvenir shopping experience.</p>
            <h2>How Can Souvenirs Help You?</h2>
            <p>Souvenirs provides personalized souvenir recommendations based on the regions you've visited, cultural
                preferences, local customs, and the recipient's profile. Whether you're looking for traditional
                handicrafts, iconic landmarks, or unique cultural artifacts, Souvenirs can suggest the perfect souvenir
                for every occasion.</p>
            <h2>Why Use Souvenirs?</h2>
            <p>With Souvenirs, you can simplify souvenir shopping, preserve memories, and support local communities. Say
                goodbye to souvenir shopping stress and endless browsing through crowded market stalls. With Souvenirs'
                personalized recommendations, you can quickly find the perfect souvenir for yourself or your loved ones,
                saving time and energy for more enjoyable travel experiences.</p>
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