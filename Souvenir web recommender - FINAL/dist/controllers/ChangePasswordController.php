<?php
session_start();
include '../models/database.php';

class ChangePasswordController {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        $this->handleRequest();
    }

    private function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processPasswordChange();
        }
    }

    private function processPasswordChange() {
        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $new_pass_confirm = $_POST['conf_new_pass'];

        if ($new_pass !== $new_pass_confirm) {
            $_SESSION['message'] = "New passwords do not match.";
            header('Location: ../views/ChangePassword.php');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $user = $this->getUserById($user_id);

        if (!$user || !password_verify($old_pass, $user['password_hash'])) {
            $_SESSION['message'] = "Old password is incorrect.";
            header('Location: ../views/ChangePassword.php');
            exit();
        }

        $this->updatePassword($user_id, $new_pass);
        $this->clearSessionAndCookies();
        header('Location: ../views/Login.php');
        exit();
    }

    private function getUserById($user_id) {
        $query = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    private function updatePassword($user_id, $new_pass) {
        $new_pass_hash = password_hash($new_pass, PASSWORD_BCRYPT);

        $query = $this->db->prepare("UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id");
        $query->bindParam(':password_hash', $new_pass_hash);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
    }

    private function clearSessionAndCookies() {
        $_SESSION['message'] = "Password updated successfully.";
        $_SESSION = array();
        session_destroy();
        setcookie('user_id', '', time() - 3600, "/");
        setcookie('username', '', time() - 3600, "/");
    }
}

$controller = new ChangePasswordController();
?>
