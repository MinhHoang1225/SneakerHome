<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once "../component/linkbootstrap5.php" ?>
    <?php include "../assets/css/login.css.php" ?>
</head>
<body>
    <div class="container">
        <a href="../controller/home"><div class="btn-close"></div></a>
        <div class="row">
            <div class="col-10"></div>
            <div class="col-2 login-register-btn">
                <button type="button" onclick="window.location.href='../controller/logincontroller.php';">Login</button>
                <button type="button" onclick="window.location.href='../controller/registercontroller.php';">Register</button>
            </div>
        </div>
            <?php if (!empty($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo $_SESSION['error_message'];  
                        unset($_SESSION['error_message']);  
                    ?>
                </div>
            <?php endif; ?>     
        <form  action="../controller/logincontroller.php" method="POST">
            <div class="row pt-5">
                <div class="col-6"></div>
                <div class="col-6">
                    <h2 class="title">Sign in your account now</h2>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-4">
                    <img src="../assets/img/Shoe Logo.png" alt="">
                </div>
                <div class="col-8">
                    <div class="input-info pt-5">
                        <div>Email:</div>
                        <div>
                            <input type="text" name="email" id="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="input-info">
                        <div>Password:</div>
                        <div>
                            <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4 d-flex login-part-btn ">
                    <button type="submit" class="px-5 py-3 btn-login" href="../controller/logincontroller.php">Login</button>
                    <a href="../controller/registercontroller.php"><div>Register<i class="fa-solid fa-arrow-right pt-2"></i></div></a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
