<?php

session_start();

// Unset all the session variabiles
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete cookies
setcookie('user_id', '', time()-3600, "/");
setcookie('username', '', time()-3600, "/");

// Redirect to Home page (not connected)
header("Location: home.php");
exit();           
?>