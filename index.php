<?php
require 'includes/login_details.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-6 mx-auto mt-5">
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
                    <h3 class="text-center text-info mb-4">Login</h3>
                    <div class="form-outline shadow-md px-4 px-sm-5 py-5 py-sm-4">
                    <form action="index.php" method="POST" id="loginForm">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <div class="form-group">
                            <label for="username" class="text-info">Username / Email:</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username or email" value="<?= $username ?? ''; ?>">
                            <small class="text-danger font-weight-bold"><?= $errors['username'] ?? ''; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                            <small class="text-danger font-weight-bold"><?= $errors['password'] ?? ''; ?></small>
                        </div>
                        <div class="form-group mb-0">
                            <input type="checkbox" name="remember_me" id="remember_me" style="margin-top:7px;">
                            <label class="form-check-label text-info" for="remember_me">Remember me</label>
                        </div>
                        <div class="form-group text-center mb-0">
                            <input type="submit" name="submit"  id="submit_login" class="w-100 btn btn-info my-3" value="Login">
                            <span> Don't have an account? <a href="register.php" class="text-info">Register here</a></span>
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