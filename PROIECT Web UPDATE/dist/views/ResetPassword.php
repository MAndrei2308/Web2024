<?php
session_start();

$token = isset($_GET['token']) ? $_GET['token'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/ForgotPassword.css">
</head>
<body>
    <div class="forgot-password-container">
        <h2>Reset Password</h2>
        <form action="../controllers/ResetPasswordController.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="password" placeholder="Enter your new password" name="new_pass" id="new_pass" required>
            <input type="password" placeholder="Confirm your new password" name="conf_new_pass" id="conf_new_pass" required>
            <button type="submit" class="submit">Reset Password</button>
        </form>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
