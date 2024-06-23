<?php
session_start();

if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    // Restaureaza sesiunea din cookie-uri
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}

if (isset($_SESSION['user_id'])) {
    // Utilizatorul este autentificat, redirectioneaza catre pagina virual map conectata
    header("Location: ../views/Conectat_VirtualMap.php");
    exit();
} else {
    // Utilizatorul este autentificat, redirectioneaza catre pagina virtual map neconectata
    header("Location: ../views/VirtualMap.php");
    exit();
}
?>
