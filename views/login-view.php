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
        <div class="btn-close"></div>
        <div class="row">
            <div class="col-10"></div>
            <div class="col-2 login-register-btn">
                <button type="">Login</button>
                <button type="">Register</button>
            </div>
        <div class="row pt-5">
            <div class="col-6"></div>
            <div class="col-6">
                <h2 class="title">Sign in your account now</h2>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-4"><img src="../assets/img/Shoe Logo.png" alt="" ></div>
            <div class="col-8">
                <div class="input-info pt-5">
                    <div>Username:</div>
                    <div><input type="text" placeholder="username"></div>
                </div>
                <div class="input-info">
                    <div>Password:</div>
                    <div><input type="text" placeholder="password"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 d-flex login-part-btn ">
                <button type="submit" class="px-5 py-3">Login</button>
                <div class="pt-2 ">Register<i class="fa-solid fa-arrow-right pt-2"></i></div>
            </div>
        </div>


        </div>
    </div>
</body>
</html>