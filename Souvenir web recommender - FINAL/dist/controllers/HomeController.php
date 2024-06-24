<?php
session_start();

class HomeController {
    public function __construct() {
        $this->initializeSessionFromCookies();
    }

    private function initializeSessionFromCookies() {
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['username'] = $_COOKIE['username'];
        }
    }

    public function handleRequest() {
        if (isset($_SESSION['user_id'])) {
            // Utilizatorul este autentificat, redirectioneaza catre pagina pricipala conectata
            header("Location: ../views/Conectat_Home.php");
            exit();
        } else {
            // Utilizatorul este autentificat, redirectioneaza catre pagina pricipala neconectata
            header("Location: ../views/PaginaPrincipala.php");
            exit();
        }
    }
}

$controller = new HomeController();
$controller->handleRequest();
?>
