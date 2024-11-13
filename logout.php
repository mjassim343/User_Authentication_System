<?php

session_start();
require_once 'config/database.php';

// Remove the remember me token from the database
if (isset($_SESSION['user_id'])){
    $update_user = $connect->prepare("UPDATE users SET remember_token = NULL WHERE id = :id");
    $update_user->execute(['id' => $_SESSION['user_id']]);
    $connect = null;
}

// Destroy session and remove cookies
session_unset();
session_destroy();
setcookie("remember_me", "", time() - 3600, BASE_PATH, BASE_URL, false, true);

header("Location: index.php");

?>