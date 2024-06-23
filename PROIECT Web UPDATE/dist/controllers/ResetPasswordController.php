<?php
session_start();
include '../models/database.php';
include '../models/UserModel.php';
include '../models/PasswordResetModel.php';

class ResetPasswordController {
    private $db;
    private $passwordResetModel;
    private $userModel;

    public function __construct() {
        $this->initializeDatabase();
        $this->initializeModels();
    }

    private function initializeDatabase() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    private function initializeModels() {
        $this->passwordResetModel = new PasswordResetModel($this->db);
        $this->userModel = new UserModel($this->db);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processResetPasswordRequest();
        }
    }

    private function processResetPasswordRequest() {
        $token = $_POST['token'];
        $new_pass = $_POST['new_pass'];
        $conf_new_pass = $_POST['conf_new_pass'];

        if ($new_pass !== $conf_new_pass) {
            $_SESSION['message'] = "New passwords do not match.";
            header('Location: ../views/ResetPassword.php?token=' . htmlspecialchars($token));
            exit();
        }

        $resetRequest = $this->passwordResetModel->getResetRequestByToken($token);

        if ($resetRequest && strtotime($resetRequest['token_expiry']) > time()) {
            $new_pass_hash = password_hash($new_pass, PASSWORD_BCRYPT);
            $this->userModel->updatePassword($resetRequest['user_id'], $new_pass_hash);

            $this->passwordResetModel->deleteResetRequest($resetRequest['id']);

            $_SESSION['message'] = "Password updated successfully.";
            header('Location: ../views/Login.php');
            exit();
        } else {
            $_SESSION['message'] = "Invalid or expired token.";
            header('Location: ../views/ResetPassword.php?token=' . htmlspecialchars($token));
            exit();
        }
    }
}

$controller = new ResetPasswordController();
$controller->handleRequest();
?>
