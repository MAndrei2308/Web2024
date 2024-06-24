<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

include '../models/database.php';

$database = Database::getInstance();
$db = $database->getConnection();

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM Profiles WHERE user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$first_name = isset($profile['first_name']) ? $profile['first_name'] : '';
$last_name = isset($profile['last_name']) ? $profile['last_name'] : '';
$username = isset($profile['username']) ? $profile['username'] : '';
$gender = isset($profile['gender']) ? $profile['gender'] : '';
$email = isset($profile['email']) ? $profile['email'] : '';

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/ProfilPaginaDesign.css">
    <title>Profile</title>
</head>

<body>

<div class="profile-container">

    <div class="profile-container__leftbox">
        <nav>
            <a href="../controllers/ProfilController.php" class="nav__user">
                <img src="../../img/profile-user.png" alt="Profile" class="nav__button-user">
            </a>
            <a href="../controllers/FavoriteLogController.php">
                <img src="../../img/iconheart-rose.png" alt="Favorite" class="nav__button-favorite">
            </a>
            <a href="../controllers/LogoutController.php">
                <img src="../../img/logout.png" alt="Logout" class="nav__button-logout">
            </a>
            <a href="../controllers/HomeController.php">
                <img src="../../img/undo.png" alt="Undo" class="nav__button-undo">
            </a>
        </nav>
    </div>

    <div class="profile-container__rightbox">
        <div class="profile">
            <h1 class="profile__title">Personal Info</h1>
            <h2 class="profile__subtitle">Full Name</h2>
            <form action="../controllers/UpdateProfilController.php" method="post">
                <p class="profile__info">
                    <label for="first_name"></label>
                    <input type="text" value="<?php echo htmlspecialchars($first_name); ?>" name="first_name"
                           id="first_name">

                    <label for="last_name"></label>
                    <input type="text" value="<?php echo htmlspecialchars($last_name); ?>" name="last_name"
                           id="last_name">

                    <button class="profile__btn" name="update_name" type="submit">update</button>
                </p>
            </form>
            <h2 class="profile__subtitle">Username</h2>
            <form action="../controllers/UpdateProfilController.php" method="post">
                <p class="profile__info">
                    <label for="username"></label>
                    <input type="text" value="<?php echo htmlspecialchars($username); ?>" name="username"
                           id="username">

                    <button class="profile__btn" name="update_username" type="submit">update</button>
                </p>
            </form>
            <h2 class="profile__subtitle">Gender</h2>
            <form action="../controllers/UpdateProfilController.php" method="post">
                <p class="profile__info">
                    <label for="gender"></label>
                    <input type="text" value="<?php echo htmlspecialchars($gender); ?>" name="gender" id="gender">

                    <button class="profile__btn" name="update_gender" type="submit">update</button>
                </p>
            </form>
            <h2 class="profile__subtitle">Email</h2>
            <form action="../controllers/UpdateProfilController.php" method="post">
                <p class="profile__info">
                    <label for="email"></label>
                    <input type="text" value="<?php echo htmlspecialchars($email); ?>" name="email" id="email">

                    <button class="profile__btn" name="update_email" type="submit">update</button>
                </p>
            </form>
            <h2 class="profile__subtitle">Password</h2>
            <p class="profile__info">
                <a href="ChangePassword.php">Change password</a>
            </p>

        </div>
        <?php if ($message): ?>
            <p class="profile__message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>
</div>

</body>

</html>