<?php
session_start();
include '../models/database.php';
include '../models/UserModel.php';
include '../models/PasswordResetModel.php';

class SendResetEmailController {
    private $db;
    private $userModel;
    private $passwordResetModel;

    public function __construct() {
        $this->initializeDatabase();
        $this->initializeModels();
    }

    private function initializeDatabase() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    private function initializeModels() {
        $this->userModel = new UserModel($this->db);
        $this->passwordResetModel = new PasswordResetModel($this->db);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processPasswordResetRequest();
        }
    }

    private function processPasswordResetRequest() {
        $email = $_POST['email'];

        $user = $this->userModel->getUserByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->passwordResetModel->storeResetToken($user['user_id'], $token, $expiry_time);

            $reset_link = "https://localhost/PROIECT%20Web%20UPDATE/dist/views/ResetPassword.php?token=$token";
            $subject = "Reset Your Password";
            $message = "Click on the following link to reset your password: $reset_link";
            $headers = 'From: andrei.moisa.23@gmail.com' . "\r\n" .
                'Reply-To: andrei.moisa.23@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if (mail($email, $subject, $message, $headers)) {
                $_SESSION['message'] = "A reset link has been sent to your email address.";
                header('Location: ../views/Login.php');
                exit();
            } else {
                $_SESSION['message'] = "Failed to send email.";
            }
        } else {
            $_SESSION['message'] = "Email address not found.";
        }

        header('Location: ../views/ForgotPassword.php');
        exit();
    }
}

$controller = new SendResetEmailController();
$controller->handleRequest();
?>
