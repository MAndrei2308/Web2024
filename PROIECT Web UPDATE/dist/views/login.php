<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../controllers/HomeController.php");
    exit();
}

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/Login.css">
</head>


<body>
<div class="login-container">
    <h2>Login Form</h2>

    <div class="pozaProfil">
        <img src="../../img/img_profil.png" alt="profil">
    </div>
    <form action="../controllers/LoginController.php" method="post">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" id="username" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" id="password" required>

        <div class="check">
            <input type="checkbox" name="rememberMe" id="rememberMe">
            <label for="rememberMe">Remember me</label>
        </div>

        <button type="submit" class="submit">Login</button>
        <div class="cancel-forgot">
            <a href="../controllers/HomeController.php" class="cancelButton">Cancel</a>

            <span class="password">Forgot <a href="ForgotPassword.php">password</a>? Or <a href="SignUp.php">sign up</a></span>
        </div>
    </form>

    <?php if($error_message): ?>
    <div class="error-message" style="color: red;">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
    <?php endif; ?>

    <?php if($success_message): ?>
    <div class="success_message" style="color: green;">
        <?php echo htmlspecialchars($success_message); ?>
    </div>
    <?php endif; ?>

</div>
</body>

</html>