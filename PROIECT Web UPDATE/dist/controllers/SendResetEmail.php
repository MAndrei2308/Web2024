<?php
session_start();
include '../models/database.php';
include '../models/UserModel.php';
include '../models/PasswordResetModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verifică dacă adresa de e-mail există în baza de date
    $database = Database::getInstance();
    $db = $database->getConnection();
    $userModel = new UserModel($db);
    $user = $userModel->getUserByEmail($email);

    if ($user) {
        // Generăm un token unic
        $token = bin2hex(random_bytes(50));
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // Tokenul expiră după o oră

        // Salvăm tokenul și ora expirării în noua tabelă
        $passwordResetModel = new PasswordResetModel($db);
        $passwordResetModel->storeResetToken($user['user_id'], $token, $expiry_time);

        // Trimitem e-mailul de resetare
        $reset_link = "http://localhost/PROIECT%20Web%20UPDATE%20-%20Copy/dist/views/ResetPassword.php?token=$token";
        $subject = "Reset Your Password";
        $message = "Click on the following link to reset your password: $reset_link";
        $headers = 'From: andrei.moisa.23@gmail.com' . "\r\n" .
    'Reply-To: andrei.moisa.23@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

        // Trimiterea e-mailului
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
?>
