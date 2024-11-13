<?php
session_start();
require 'config/database.php';

if(isset($_GET['token'])){

    $token = $_GET['token'];

    try{
        // Check if token is valid
        $select_user = $connect->prepare("SELECT id FROM users WHERE verification_token = :token");
        $select_user->execute(['token' => $token]);
        if($select_user->rowCount() > 0){
            // Fetch the user id by using token
            $user = $select_user->fetch(PDO::FETCH_ASSOC);

            // Update email_verified status to true
            $update_user = $connect->prepare("UPDATE users SET email_verified = :email_verified, verification_token = NULL WHERE id = :id");
            $update_user->execute(['email_verified' => 1, 'id' => $user['id']]);

            // Show the success message using session
            $_SESSION['message'] = 'Your email is verified successfully! You can now log in.';
            $_SESSION['status'] = 'success';
        } 
        else{
            // Show the failed message using session
            $_SESSION['message'] = 'Invalid or expired verification link.';
            $_SESSION['status'] = 'failed';
        }
    }
    catch(PDOException $e){
        // Log exception for debugging
        error_log("Database error: " . $e->getMessage());

        // Show the failed message using session
        $_SESSION['message'] = 'Database error: ' . $e->getMessage();
        $_SESSION['status'] = 'failed';
    }
    $connect = null;
}
else{
    // Show the failed message using session
    $_SESSION['message'] = 'No verification token provided.';
    $_SESSION['status'] = 'failed';
}

// Redirect back to login page if successful
header("Location: index.php");
exit;

?>