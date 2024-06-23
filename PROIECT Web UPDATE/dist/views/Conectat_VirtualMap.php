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
    <link rel="stylesheet" href="../css/Conectat_VirtualMapDesign.css">
    <title>Virtual Map</title>
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
            <label for="user" class="user-icon"><a href="ProfilPagina.php"><img src="../../img/profile-user.png" alt="profile">
                </a></label>

        </div>
    </header>



    <div class="container">
        <img src="../../img/europa.png" class="container__image" alt="HartaEuropei" usemap="#euromap">
        <map name="euromap">
            <area shape="poly"
                  coords="167,450,162,452,159,456,164,462,165,470,147,472,142,467,120,470,122,482,141,488,156,494,157,502,170,512,169,530,163,560,184,571,191,569,191,566,201,571,227,573,227,563,238,558,249,557,264,564,271,564,273,555,286,552,288,546,279,544,280,538,275,530,280,524,279,516,276,509,268,511,269,505,285,489,288,475,294,466,273,455,259,455,255,449,250,450,249,444,241,449,239,441,227,434,222,434,219,428,211,428,208,433,206,443,201,448,189,449,184,458,173,457"
                  href="Conectat_Category.php#franta" alt="Franta">
            <area shape="poly"
                  coords="273,455,294,466,288,475,285,489,297,487,305,485,314,489,315,497,318,499,325,498,323,495,317,493,317,489,323,491,331,489,338,490,352,485,357,487,358,477,370,468,355,457,349,440,377,428,384,428,378,399,373,394,375,377,370,371,362,371,367,363,358,366,350,366,340,376,332,374,334,366,321,367,318,360,304,359,303,367,308,378,302,380,300,383,291,379,281,380,282,394,275,399,279,405,276,409,276,413,269,415,267,432,271,438,267,444"
                  href="Conectat_Category.php#germania" alt="Germania">
            <area shape="poly"
                  coords="279,516,280,524,275,530,280,538,279,544,288,546,286,552,294,548,301,541,315,544,325,556,328,565,358,590,366,592,374,599,387,609,392,611,394,618,397,625,396,631,394,635,394,639,389,642,357,642,352,647,313,623,314,599,311,596,306,596,302,598,294,599,299,611,298,625,302,630,313,623,352,647,380,664,384,662,384,650,389,642,394,639,395,643,401,634,402,630,410,622,403,616,403,610,409,606,414,607,624,613,425,606,396,588,395,583,385,582,367,556,350,542,352,523,357,520,357,503,350,501,349,497,338,496,331,500,326,500,324,504,319,505,317,509,309,508,306,516,297,507,290,515"
                  href="Conectat_Category.php#italia" alt="Italia">
            <area shape="poly"
                  coords="455,514,460,525,464,525,464,534,479,537,480,544,486,549,520,551,529,546,548,545,559,551,559,540,565,533,571,532,572,526,568,524,560,526,554,523,552,512,556,504,537,474,525,481,518,480,512,484,485,479,474,487,463,508,455,514"
                  href="Conectat_Category.php#romania" alt="Romania">
            <area shape="poly"
                  coords="163,560,184,571,188,575,204,574,227,573,227,581,210,592,199,594,195,601,183,613,184,630,174,640,173,649,163,653,155,662,128,664,122,668,112,668,110,673,105,673,94,658,85,656,86,674,92,644,86,636,89,632,92,629,85,621,91,618,93,601,92,596,101,588,94,581,85,583,75,582,73,578,66,581,67,571,60,563,70,559,76,553,81,553,87,556"
                  href="Conectat_Category.php#spania" alt="Spania">
        </map>
    </div>
    <div class="spacer"></div>

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
                    <li><a href="Conectat_AboutUs.php">About us</a></li>
                    <li><a href="Conectat_Help.php">Help</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__copyright">
            <p>&copy; 2024 Souvenirs. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>