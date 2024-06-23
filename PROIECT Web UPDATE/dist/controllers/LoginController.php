<?php
session_start();
include_once '../models/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = Database::getInstance();
    $db = $database->getConnection();

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $rememberMe = isset($_POST['rememberMe']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password_hash'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];

                // Set cookies
                $cookie_duration = $rememberMe ? (30 * 24 * 60 * 60) : 0; // 30 days or 0
                setcookie('user_id', $row['user_id'], time() + $cookie_duration, "/");
                setcookie('username', $row['username'], time() + $cookie_duration, "/");

                // Redirectionare pe baza rolului
                if ($row['role'] == 'ADMIN') {
                    header("Location: ../views/AdminPage.php");
                } else {
                    header("Location: ../views/Conectat_Home.php");
                }
                exit();
            } else {
                $_SESSION['error_message'] = "No user found!";
                header("Location: ../views/Login.php");
                exit();
            }

        } else {
            $_SESSION['error_message'] = "No user found!";
            header("Location: ../views/Login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Please fill all fields!";
        header("Location: ../views/Login.php");
        exit();
    }
}

?>