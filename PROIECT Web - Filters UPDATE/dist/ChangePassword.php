<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="./css/ForgotPassword.css">
</head>
<body>
    <div class="forgot-password-container">
        <h2>Change Password</h2>
        <form action="php/changePassword.php" method="post">
            <input type="password" placeholder="Enter your previous password" name="old_pass" id="old_pass" required>
            <input type="password" placeholder="Enter your new password" name="new_pass" id="new_pass" required>
            <input type="password" placeholder="Confirm your new password" name="new_pass" id="new_pass" required>
            
            <button type="submit" class="submit">Change password</button>
        </form>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
