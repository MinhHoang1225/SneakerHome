<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/linkbootstrap5.php" ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/assets/css/login.css.php" ?>
</head>
<body>
<div class="centered-wrapper">
    <div class="container">
        <!-- Close Button -->
        <a href="../controllers/home" class="btn-close"></a>


        <!-- Error Message -->
        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error_message'];  
                    unset($_SESSION['error_message']);  
                ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="../controllers/login" method="POST">
            <!-- Form Title -->
            <div class="row text-center pt-5">
                <div class="col-12">
                    <h2 class="title">Welcome Back</h2>
                    <p class="subtitle">Sign in to continue accessing your account</p>
                </div>
            </div>

            <!-- Logo and Input Fields -->
            <div class="row pt-4 align-items-center">
                <!-- Logo -->
                <div class="col-md-4 text-center">
                    <img src="../assets/img/Shoe Logo.png" alt="Logo" class="img-fluid logo">
                </div>

                <!-- Input Fields -->
                <div class="col-md-8">
                    <div class="input-info mb-4">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-info mb-4">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                </div>
            </div>

            <!-- Submit and Register Links -->
            <div class="row mt-4">
                <div class="col-8"></div>
                <div class="col-4 d-flex justify-content-end login-part-btn ">
                    <button type="submit" class="btn-login">Login</button>
                    <a href="../controllers/register" class="ml-4 register-link">Register</a>
                </div>
            </div>
        </form>
    </div>
</div>


</body>
</html>
