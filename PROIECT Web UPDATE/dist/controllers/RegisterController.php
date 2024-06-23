<?php
session_start();
include_once '../models/database.php';

class SignUpController {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        $this->handleRequest();
    }

    private function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processSignUp();
        }
    }

    private function processSignUp() {
        $username = htmlspecialchars(strip_tags($_POST['username']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = htmlspecialchars(strip_tags($_POST['password']));
        $password_repeat = htmlspecialchars(strip_tags($_POST['password_repeat']));

        if ($this->validateInput($username, $email, $password, $password_repeat)) {
            if ($this->isPasswordMatch($password, $password_repeat)) {
                if (!$this->isUserExist($username, $email)) {
                    $this->registerUser($username, $email, $password);
                } else {
                    $this->setErrorMessage("Username or email already exists!");
                    $this->redirectToSignUp();
                }
            } else {
                $this->setErrorMessage("Passwords do not match!");
                $this->redirectToSignUp();
            }
        } else {
            $this->setErrorMessage("Please fill all fields!");
            $this->redirectToSignUp();
        }
    }

    private function validateInput($username, $email, $password, $password_repeat) {
        return !empty($username) && !empty($email) && !empty($password) && !empty($password_repeat);
    }

    private function isPasswordMatch($password, $password_repeat) {
        return $password === $password_repeat;
    }

    private function isUserExist($username, $email) {
        $query = "SELECT * FROM Users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    private function registerUser($username, $email, $password) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO Users (username, email, password_hash) VALUES (:username, :email, :password_hash)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);

        if ($stmt->execute()) {
            $user_id = $this->db->lastInsertId();
            $this->createUserProfile($user_id, $username, $email);
        } else {
            $this->setErrorMessage("Error registering user!");
            $this->redirectToSignUp();
        }
    }

    private function createUserProfile($user_id, $username, $email) {
        $query_profile = "INSERT INTO Profiles (user_id, username, email, gender, first_name, last_name) VALUES (:user_id, :username, :email, 'male/female', 'first name', 'last name')";
        $stmt_profile = $this->db->prepare($query_profile);
        $stmt_profile->bindParam(':user_id', $user_id);
        $stmt_profile->bindParam(':username', $username);
        $stmt_profile->bindParam(':email', $email);

        if ($stmt_profile->execute()) {
            $_SESSION['success_message'] = "User registered successfully!";
            $this->redirectToLogin();
        } else {
            $this->setErrorMessage("Error creating profile");
            $this->redirectToSignUp();
        }
    }

    private function setErrorMessage($message) {
        $_SESSION['error_message'] = $message;
    }

    private function redirectToSignUp() {
        header("Location: ../views/SignUp.php");
        exit();
    }

    private function redirectToLogin() {
        header("Location: ../views/Login.php");
        exit();
    }
}

$controller = new SignUpController();
?>
