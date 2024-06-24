<?php
session_start();

class FavoriteLogController {
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
            // Utilizatorul este autentificat, redirectioneaza catre pagina favorite
            header("Location: ../views/FavoritePagina.php");
            exit();
        } else {
            // Utilizatorul este autentificat, redirectioneaza catre pagina login
            header("Location: ../views/Login.php");
            exit();
        }
    }
}

$controller = new FavoriteLogController();
$controller->handleRequest();
?>
