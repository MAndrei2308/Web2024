<?php
session_start();
include_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $password_repeat = htmlspecialchars(strip_tags($_POST['password_repeat']));

    if (!empty($username) && !empty($email) && !empty($password) && !empty($password_repeat)) {
        if ($password !== $password_repeat) {
            $_SESSION['error_message'] = "Passwords do not match!";
            header("Location: ../SignUp.php");
            exit();
        }

        $query = "SELECT * FROM Users WHERE username = :username OR email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error_message'] =  "Username or email already exists!";
            header("Location: ../SignUp.php");
            exit();
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO Users (username, email, password_hash) VALUES (:username, :email, :password_hash)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $password_hash);

            if ($stmt->execute()) {
                // Obtin id-ul userului nou creat pentru a putea insera si in tabela profile
                $user_id = $db->lastInsertId();

                // Inserez in profile
                $query_profile = "INSERT INTO Profiles (user_id, username, email, gender, first_name, last_name) VALUES (:user_id, :username, :email, 'male/female', 'first name', 'last name')";
                $stmt_profile = $db->prepare($query_profile);
                $stmt_profile->bindParam(':user_id', $user_id);
                $stmt_profile->bindParam(':username', $username);
                $stmt_profile->bindParam(":email", $email);

                if ($stmt_profile->execute()) {
                    $_SESSION['success_message'] = "User registered successfully!";
                    header("Location: ../views/Login.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Error creating profile";
                    header("Location: ../views/SignUp.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Error registering user!";
                header("Location: ../views/SignUp.php");
                exit();
            }
        }
    } else {
        $_SESSION['error_message'] = "Please fill all fields!";
        header("Location: ../views/SignUp.php");
        exit();
    }
}
?>