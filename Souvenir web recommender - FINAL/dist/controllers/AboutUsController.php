<?php
session_start();

class AboutUsController {
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
            header("Location: ../views/Conectat_AboutUs.php");
            exit();
        } else {
            header("Location: ../views/AboutUs.php");
            exit();
        }
    }
}

$controller = new AboutUsController();
$controller->handleRequest();
?>
