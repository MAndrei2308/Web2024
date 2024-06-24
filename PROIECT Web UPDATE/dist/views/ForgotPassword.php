<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/ForgotPassword.css">
</head>
<body>
    <div class="forgot-password-container">
        <h2>Forgot Password</h2>
        <form action="../controllers/SendResetEmailController.php" method="post">
            <input type="email" placeholder="Enter your email address" name="email" id="email" required>
            <button type="submit" class="submit">Send Reset Link</button>
        </form>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
