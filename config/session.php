<?php
session_start();

// Check if the session is set, otherwise, check the "Remember Me" cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])){

    // Get user details using remember token
    $remember_token = $_COOKIE['remember_me'];
    $select_user = $connect->prepare("SELECT * FROM users WHERE remember_token = :remember_token");
    $select_user->execute(['remember_token' => $remember_token]);
    if ($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){
        $_SESSION['user_id'] = $fetch_user['id'];
        $_SESSION['users'] = $fetch_user;
    }
    // Close database connection
    $connect = null;
}

// Check if the session is not set, then redirected to login page
if (!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}


?>