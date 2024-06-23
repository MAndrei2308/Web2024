<?php
session_start();
include_once '../models/database.php';

class LoginController {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        $this->handleRequest();
    }

    private function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
        }
    }

    private function processLogin() {
        $username = htmlspecialchars(strip_tags($_POST['username']));
        $password = htmlspecialchars(strip_tags($_POST['password']));
        $rememberMe = isset($_POST['rememberMe']);

        if (!empty($username) && !empty($password)) {
            $user = $this->getUserByUsername($username);

            if ($user && password_verify($password, $user['password_hash'])) {
                $this->setUserSession($user);
                $this->setUserCookies($user, $rememberMe);
                $this->redirectUser($user['role']);
            } else {
                $this->setErrorMessage("No user found!");
                $this->redirectToLogin();
            }
        } else {
            $this->setErrorMessage("Please fill all fields!");
            $this->redirectToLogin();
        }
    }

    private function getUserByUsername($username) {
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    private function setUserSession($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }

    private function setUserCookies($user, $rememberMe) {
        $cookie_duration = $rememberMe ? (30 * 24 * 60 * 60) : 0; // 30 days or 0
        setcookie('user_id', $user['user_id'], time() + $cookie_duration, "/");
        setcookie('username', $user['username'], time() + $cookie_duration, "/");
    }

    private function redirectUser($role) {
        if ($role == 'ADMIN') {
            header("Location: ../views/AdminPage.php");
        } else {
            header("Location: ../views/Conectat_Home.php");
        }
        exit();
    }

    private function setErrorMessage($message) {
        $_SESSION['error_message'] = $message;
    }

    private function redirectToLogin() {
        header("Location: ../views/Login.php");
        exit();
    }
}

$controller = new LoginController();
?>
