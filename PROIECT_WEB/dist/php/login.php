<?php
session_start();
include_once 'database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if(!empty($username) && !empty($password)) {
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username',$username);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $row['password_hash'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                header("Location: ../Conectat_Home.html");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password!";
            }
        } else {
            $_SESSION['error'] = "No user found!";
        }
    } else {
        $_SESSION['error'] = "Please fill all fields!";
    }

    header("Location: ../Login.html");
}


?>