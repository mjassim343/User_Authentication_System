<?php
require_once 'includes/register_details.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-6 mt-3">
                    <?php 
                        if (!empty($_SESSION['message'])):
                        $status = ($_SESSION['status'] == 'failed')?'danger':'success';
                        echo '
                        <div class="alert alert-'.$status.'">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>'.ucfirst($_SESSION['status']).'!</strong>
                            <p class="mb-0">'.$_SESSION['message'].'</p>
                        </div>';
                        unset($_SESSION['message']);
                        unset($_SESSION['status']);
                        endif;
                    ?>
                    <h3 class="text-center text-info mb-4">Registration</h3>
                    <div class="form-outline shadow-md px-4 px-sm-5 py-5 py-sm-4 mb-5">
                    <form action="register.php" method="POST" id="registerForm">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <div class="form-group">
                            <label for="first_name" class="text-info">First Name:</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter your first name" value="<?= $first_name ?? ''; ?>">
                            <small class="text-danger font-weight-bold"><?= $errors['first_name'] ?? ''; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="text-info">Last Name:</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter your last name" value="<?= $last_name ?? ''; ?>">
                            <small class="text-danger font-weight-bold"><?= $errors['last_name'] ?? ''; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-info">Email:</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter your email address" value="<?= $email ?? ''; ?>">
                            <small class="text-danger font-weight-bold"><?= $errors['email'] ?? ''; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" value="<?= $username ?? ''; ?>">
                            <small class="text-danger font-weight-bold"><?= $errors['username'] ?? ''; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" value="<?= $_POST['password'] ?? ''; ?>">
                            <?php
                            if(!empty($errors['password'])):
                                foreach($errors['password'] as $error):
                                    echo '<small class="text-danger font-weight-bold">'.htmlspecialchars($error).'</small></br>';
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="text-info">Confirm Password:</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter your confirm password">
                            <small class="text-danger font-weight-bold"><?= $errors['confirm_password'] ?? ''; ?></small>
                        </div>
                        <div class="form-group text-center mb-0">
                            <input type="submit" name="submit" id="submit_register" class="w-100 btn btn-info my-3" value="Register">
                            <span>Already have an account? <a href="index.php" class="text-info">Login here</a></span>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/jquery-3.7.1.min.js"></script>  
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>     
</body>
</html>