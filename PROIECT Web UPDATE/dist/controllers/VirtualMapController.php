<?php
session_start();

class VirtualMapController {
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
            // Utilizatorul este autentificat, redirectioneaza catre pagina virual map conectata
            header("Location: ../views/Conectat_VirtualMap.php");
            exit();
        } else {
            // Utilizatorul este autentificat, redirectioneaza catre pagina virtual map neconectata
            header("Location: ../views/VirtualMap.php");
            exit();
        }
    }
}

$controller = new VirtualMapController();
$controller->handleRequest();
?>
