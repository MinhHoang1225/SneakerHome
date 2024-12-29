<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once "./component/linkbootstrap5.php" ?>
    <?php include "./assets/css/register.css.php" ?>
</head>
<body>

<div class="centered-wrapper">
    <div class="container">
        <!-- Close Button -->
        <a href="/home" class="btn-close"></a>    

        <!-- Main Content -->
        <div class="content">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="row text-center pt-5">
                <div class="col-12">
                    <h2 class="title">Create New Account</h2>
                    <p class="subtitle">Join us now and explore exciting features!</p>
                </div>
            </div>
                <div class="col-4 text-center">
                    <img src="../assets/img/Shoe Logo.png" alt="Shoe Logo" class="logo">
                </div>
                <!-- Form -->
                <div class="col-8">

                    <form action="/User/userRegister" method="POST">
                        <div class="input-group">
                            <label for="name">Username:</label>
                            <input type="text" id="name" name="name" placeholder="Enter your username" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="input-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>
                        <div class="action-buttons d-flex justify-content-end gap-5 align-items-center">
                            <a href="./login" class="back-link">Login</a>
                            <button type="submit" class="btn-register">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<?php if (!empty($username_error) || !empty($email_error) || !empty($password_error) || !empty($confirm_password_error)): ?>
    <script>
        <?php if (!empty($username_error)): ?>
            alert('<?= $username_error ?>');
        <?php endif; ?>
        <?php if (!empty($email_error)): ?>
            alert('<?= $email_error ?>');
        <?php endif; ?>
        <?php if (!empty($password_error)): ?>
            alert('<?= $password_error ?>');
        <?php endif; ?>
        <?php if (!empty($confirm_password_error)): ?>
            alert('<?= $confirm_password_error ?>');
        <?php endif; ?>
    </script>
<?php endif; ?>
</html>