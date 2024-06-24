<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: Conectat_Home.php");
    exit();
}

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/SignUp.css">
</head>

<body>
<div class="sign-up-container">
    <h2>Sign Up Form</h2>

    <div class="pozaProfil">
        <img src="../../img/img_profil.png" alt="profil">
    </div>

    <form action="../controllers/RegisterController.php" method="post">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" id="username" required>

        <label for="email"><b>Email</b></label>
        <input type="email" placeholder="Enter email address" name="email" id="email" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" id="password" required>

        <label for="password_repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Enter Password" name="password_repeat" id="password_repeat" required>

        <span class="Terms-Privacy">By creating an account you agree to our <a href="#">Terms & Privacy</a>.</span>

        <div class="login-cancel">
            <button type="submit" class="submit">Sign Up</button>
            <button type="button" class="cancelButton" onclick="history.back();">Cancel</button>

        </div>
    </form>

    <?php if($error_message): ?>
    <div class="error-message" style="color: red;">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
    <?php endif; ?>

</div>
</body>

</html>