<?php
session_start();
include '../models/database.php';

class UpdateProfilController {
    private $db;
    private $user_id;
    private $valid_genders = ['male', 'female'];

    public function __construct() {
        $this->checkSession();
        $this->initializeDatabase();
    }

    private function checkSession() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../views/Login.php");
            exit();
        }
        $this->user_id = $_SESSION['user_id'];
    }

    private function initializeDatabase() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['update_name'])) {
                $this->updateName();
            } elseif (isset($_POST['update_username'])) {
                $this->updateUsername();
            } elseif (isset($_POST['update_gender'])) {
                $this->updateGender();
            } elseif (isset($_POST['update_email'])) {
                $this->updateEmail();
            }
        }
    }

    private function updateName() {
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';

        $query = "UPDATE Profiles SET first_name = :first_name, last_name = :last_name WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':user_id', $this->user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Name updated successfully!";
        } else {
            $_SESSION['message'] = "Error updating name.";
        }
        header("Location: ../views/ProfilPagina.php");
        exit();
    }

    private function updateUsername() {
        $username = isset($_POST['username']) ? $_POST['username'] : '';

        // Check if the new username already exists
        $check_query = "SELECT * FROM Profiles WHERE username = :username AND user_id != :user_id";
        $check_stmt = $this->db->prepare($check_query);
        $check_stmt->bindParam(':username', $username);
        $check_stmt->bindParam(':user_id', $this->user_id);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $_SESSION['message'] = "Username already exists.";
        } else {
            $query = "UPDATE Profiles SET username = :username WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':user_id', $this->user_id);

            if ($stmt->execute()) {
                // Update username in the users table
                $user_query = "UPDATE Users SET username = :username WHERE user_id = :user_id";
                $user_stmt = $this->db->prepare($user_query);
                $user_stmt->bindParam(':username', $username);
                $user_stmt->bindParam(':user_id', $this->user_id);
                $user_stmt->execute();

                $_SESSION['message'] = "Username updated successfully!";
            } else {
                $_SESSION['message'] = "Error updating username.";
            }
        }
        header("Location: ../views/ProfilPagina.php");
        exit();
    }

    private function updateGender() {
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        if (in_array($gender, $this->valid_genders)) {
            $query = "UPDATE Profiles SET gender = :gender WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':user_id', $this->user_id);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Gender updated successfully!";
            } else {
                $_SESSION['message'] = "Error updating gender.";
            }
        } else {
            $_SESSION['message'] = "Invalid gender selected. The correct options are male or female.";
        }
        header("Location: ../views/ProfilPagina.php");
        exit();
    }

    private function updateEmail() {
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Check if the new email already exists
        $check_query = "SELECT * FROM Profiles WHERE email = :email AND user_id != :user_id";
        $check_stmt = $this->db->prepare($check_query);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->bindParam(':user_id', $this->user_id);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $_SESSION['message'] = "Email already exists.";
        } else {
            $query = "UPDATE Profiles SET email = :email WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $this->user_id);

            if ($stmt->execute()) {
                // Update email in the users table
                $user_query = "UPDATE Users SET email = :email WHERE user_id = :user_id";
                $user_stmt = $this->db->prepare($user_query);
                $user_stmt->bindParam(':email', $email);
                $user_stmt->bindParam(':user_id', $this->user_id);
                $user_stmt->execute();

                $_SESSION['message'] = "Email updated successfully!";
            } else {
                $_SESSION['message'] = "Error updating email.";
            }
        }
        header("Location: ../views/ProfilPagina.php");
        exit();
    }
}

$controller = new UpdateProfilController();
$controller->handleRequest();
?>
