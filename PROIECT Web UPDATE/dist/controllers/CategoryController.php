<?php
session_start();

class CategoryController{
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
            // Utilizatorul este autentificat, redirectioneaza catre pagina de about conectata
            header("Location: ../views/Conectat_Category.php");
            exit();
        } else {
            // Utilizatorul este autentificat, redirectioneaza catre pagina de about neconectata
            header("Location: ../views/Category.php");
            exit();
        }
    }
}

$controller = new CategoryController();
$controller->handleRequest();
?>