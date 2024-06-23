<?php
session_start();
include '../models/database.php';
include '../models/UserModel.php';
include '../models/PasswordResetModel.php'; // Adăugăm noul model

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_pass = $_POST['new_pass'];
    $conf_new_pass = $_POST['conf_new_pass'];

    if ($new_pass !== $conf_new_pass) {
        $_SESSION['message'] = "New passwords do not match.";
        header('Location: ../views/ResetPassword.php?token=' . htmlspecialchars($token));
        exit();
    }

    $database = Database::getInstance();
    $db = $database->getConnection();
    $passwordResetModel = new PasswordResetModel($db);
    $userModel = new UserModel($db);

    // Verificăm tokenul și expirarea acestuia
    $resetRequest = $passwordResetModel->getResetRequestByToken($token);

    if ($resetRequest && strtotime($resetRequest['token_expiry']) > time()) {
        $new_pass_hash = password_hash($new_pass, PASSWORD_BCRYPT);
        $userModel->updatePassword($resetRequest['user_id'], $new_pass_hash);

        // Ștergem tokenul din tabelă după ce parola a fost resetată
        $passwordResetModel->deleteResetRequest($resetRequest['id']);

        $_SESSION['message'] = "Password updated successfully.";
        header('Location: ../views/Login.php');
        exit();
    } else {
        $_SESSION['message'] = "Invalid or expired token.";
        header('Location: ../views/ResetPassword.php?token=' . htmlspecialchars($token));
        exit();
    }
}
?>
