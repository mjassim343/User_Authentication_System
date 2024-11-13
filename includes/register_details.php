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
        // Store the failed message using session
        $_SESSION['message'] = 'Invalid CSRF Token';
        $_SESSION['status'] = 'failed';
    }
    else{
        // Sanitize and assign form data
        $first_name = sanitize($_POST['first_name']);
        $last_name = sanitize($_POST['last_name']);
        $email = sanitize($_POST['email']);
        $username = sanitize($_POST['username']);
        $password = sanitize($_POST['password']);
        $confirm_password = sanitize($_POST['confirm_password']);

        // Validate the form data
        if(empty($first_name)){
            $errors['first_name'] = 'First name is required';
        }
        else if(strlen($first_name) < 3){
            $errors['first_name'] = 'First name should be atleast 3 characters';
        } 
        else if(strlen($first_name) > 50){
            $errors['first_name'] = 'First name should be maximum 50 characters';
        }
        if(empty($last_name)){
            $errors['last_name'] = 'Last name is required';
        }
        else if(strlen($last_name) < 3){
            $errors['last_name'] = 'Last name should be atleast 3 characters';
        } 
        else if(strlen($last_name) > 50){
            $errors['last_name'] = 'Last name should be maximum 50 characters';
        }
        if(empty($email)){
            $errors['email'] = 'Email is required';
        } 
        else if(strlen($email) > 100){
            $errors['email'] = 'Email should be maximum 100 characters';
        } 
        else if(!filter_var(trim($email), FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Please enter a valid email';
        }
        if(empty($username)){
            $errors['username'] = 'Username is required';
        }
        if(empty($password)){
            $errors['password'][] = 'Password is required';
        }
        if(strlen($password) < 8){
            $errors['password'][] = 'Password must contain at least 8 characters';
        } 
        // Check for at least one uppercase letter
        if(!preg_match('/[A-Z]/', $password)){
            $errors['password'][] = "Password must contain at least one uppercase letter.";
        }
        // Check for at least one lowercase letter
        if(!preg_match('/[a-z]/', $password)){
            $errors['password'][] = "Password must contain at least one lowercase letter.";
        }
        // Check for at least one number
        if(!preg_match('/[0-9]/', $password)){
            $errors['password'][] = "Password must contain at least one number.";
        }
        // Check for at least one special character
        if(!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors['password'][] = "Password must contain at least one special character.";
        }
        if(!empty($password) && empty($confirm_password)){
            $errors['confirm_password'] = 'Confirm password is required';
        }
        else if($password !== $confirm_password){
            $errors['confirm_password'] = 'Password does not match';
        }

        // Check unique email and username, if no input validation errors
        if(empty($errors)){
            $select_user = $connect->prepare("SELECT email,username FROM users WHERE email = :email OR username = :username");
            $select_user->execute(['email' => $email, 'username' => $username]);
            $existing_user = $select_user->fetch();
            if ($existing_user){
                if ($existing_user['email'] === $email){
                    $errors['email'] = 'Email is already taken.';
                }
                if ($existing_user['username'] === $username){
                    $errors['username'] = 'Username is already taken.';
                }
            }
        }

        // Proceed with database insertion, If no errors
        if(empty($errors)){
            try{
                // Use a transaction to ensure data consistency
                $connect->beginTransaction();
                
                // Encrypted the password by hash method
                $password = password_hash($password, PASSWORD_BCRYPT);

                // Generate a verification token
                $verification_token = generate_token();

                // Insert the user into the database
                $insert_user = $connect->prepare("INSERT INTO users (first_name, last_name, email, username, password, verification_token) VALUES (:first_name, :last_name, :email, :username, :password, :verification_token)");
                $insert_user->execute(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'username' => $username, 'password' => $password, 'password' => $password, 'verification_token' => $verification_token]);

                // Attempt to send the verification email
                if(send_verification_email($email, $verification_token)){
                    // Commit transaction if email was sent successfully
                    $connect->commit();

                    // Show success message using session
                    $_SESSION['message'] = 'Registration successful! Please check your email to verify your account.';
                    $_SESSION['status'] = 'success';

                    // Redirect back to login page
                    header("Location: index.php");
                    exit;
                } 
                else{
                    // Roll back transaction if email sending failed
                    $connect->rollBack();

                    // Set error message in session to inform the user
                    $_SESSION['message'] = 'Registration failed. Could not send verification email. Please try again.';
                    $_SESSION['status'] = 'failed';
                }
            } 
            catch(PDOException $e){
                // Roll back if there is database error
                $connect->rollBack();
                
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
