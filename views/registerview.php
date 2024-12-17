<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once "../component/linkbootstrap5.php" ?>
    <?php include "../assets/css/register.css.php" ?>
</head>
<body>

    <div class="container">
        <div class="btn-close" onclick="window.location.href='../controller/homecontroller.php';"></div>
        <div class="row">
            <div class="col-10"></div>
            <div class="col-2 login-register-btn">
                <button type="button" onclick="window.location.href='../controller/logincontroller.php';">Login</button>
                <button type="button" onclick="window.location.href='../controller/registercontroller.php';">Register</button>
            </div>

        </div>
        <div class="row pt-5">
            <div class="col-6"></div>
            <div class="col-6">
                <h2 class="title">Create new account now!</h2>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-3">
                <img src="../assets/img/Shoe Logo.png" alt="Shoe Logo">
            </div>
            <div class="col-9">
            <form action="../controller/registercontroller.php" method="POST">
                    <div class="input-info pt-5">
                        <label for="name">Username:</label>
                        <input type="text" id="name" name="name" placeholder="username" required>                       
                    </div>
                    <div class="input-info">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="email"  required>                        
                    </div>
                    <div class="input-info">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="password"   required>                        
                    </div>
                    <div class="input-info">
                        <label for="confirm_password">Confirm password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="confirm password"   required>                      
                    </div>
                    <div class="d-flex login-part-btn pt-3">
                        <a href="../controller/logincontroller.php" class="pt-2 ps-3"><i class="fa-solid fa-arrow-left pt-2"></i> Login </a>
                        <button type="submit" class="px-5 py-3">Register</button>
                    </div>
                </form>
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