<?php

session_start();
include '../models/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = Database::getInstance();
    $db = $database->getConnection();

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $new_pass_confirm = $_POST['conf_new_pass'];

    if ($new_pass !== $new_pass_confirm) {
        $_SESSION['message'] = "New passwords do not match.";
        header('Location: ../views/ChangePassword.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if(!password_verify($old_pass, $row['password_hash'])) {
        $_SESSION['message'] = "Old password is incorrect.";
        header('Location: ../views/ChangePassword.php');
        exit();
    }

    $new_pass_hash = password_hash($new_pass, PASSWORD_BCRYPT);

    $query = $db->prepare("UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id");
    $query->bindParam(':password_hash', $new_pass_hash);
    $query->bindParam(':user_id', $user_id);
    $query->execute();

    $_SESSION['message'] = "Password updated successfully.";
    header('Location: ../views/ChangePassword.php');
    exit();

}

?>