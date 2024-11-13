<?php
session_start();
require_once 'config/database.php';
require_once 'config/functions.php';

// Check if the session is set, then redirected to dashboard page
if (isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit;
}

// Initialize an empty array for errors
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Verify CSRF token
    if(!verify_csrf_token($_POST['csrf_token'])){
        $_SESSION['message'] = 'Invalid CSRF Token';
        $_SESSION['status'] = 'failed';
    }
    else{
        // Sanitize and assign form data
        $username = sanitize($_POST['username']);
        $password = sanitize($_POST['password']);

        // Validate the form data
        if(empty($username)){
            $errors['username'] = 'Username or email is required';
        }
        if(empty($password)){
            $errors['password'] = 'Password is required';
        }

        // Proceed if no input validation errors
        if(empty($errors)){
            try{
                // Fetch user data by username or email
                $select_user = $connect->prepare("SELECT * FROM users WHERE username = :username OR email = :username");
                $select_user->execute(['username' => $username]);
                if ($select_user->rowCount() > 0){
                    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                    // Verify password and email verification
                    if(!password_verify($password, $fetch_user['password'])){
                        $_SESSION['message'] = 'Invalid Credentials';
                        $_SESSION['status'] = 'failed';
                    }
                    else if($fetch_user['email_verified'] == 0){
                        $_SESSION['message'] = 'Please verify your email';
                        $_SESSION['status'] = 'failed';
                    }
                    else{
                        // Set session for user"
                        $_SESSION['user_id'] = $fetch_user['id'];
                        $_SESSION['users'] = $fetch_user;

                        // Set cookies for Remember Me
                        if (isset($_POST['remember_me'])){
                            // Generate remember token
                            $remember_token = generate_token();
                            // Set a cookie for 30 days
                            setcookie("remember_me", $remember_token, time() + (30 * 24 * 60 * 60), BASE_PATH, BASE_URL, false, true);
                            
                            // Save remember token in database
                            $datetime = date("Y-m-d H:i:s");
                            $update_user = $connect->prepare("UPDATE users SET remember_token = :remember_token, updated_at=:updated_at WHERE id = :id");
                            $update_user->execute(['remember_token' => $remember_token, 'updated_at' => $datetime, 'id' => $fetch_user['id']]);
                        }
                        header("Location: dashboard.php");
                        exit;
                    }
                }
                else{
                    $_SESSION['message'] = 'User not found with the provided username or email';
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
            // Close the database connection
            $connect = null;
        }
    }
}

?>