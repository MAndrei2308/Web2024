<?php
session_start();

class LogoutController {
    public function __construct() {
        $this->logoutUser();
    }

    private function logoutUser() {
        $this->clearSession();
        $this->clearCookies();
        $this->redirectToHomePage();
    }

    private function clearSession() {
        // Unset all the session variables
        $_SESSION = array();
        // Destroy the session
        session_destroy();
    }

    private function clearCookies() {
        // Delete cookies
        setcookie('user_id', '', time() - 3600, "/");
        setcookie('username', '', time() - 3600, "/");
    }

    private function redirectToHomePage() {
        // Redirect to Home page (not connected)
        header("Location: ../views/PaginaPrincipala.php");
        exit();
    }
}

$controller = new LogoutController();
?>
