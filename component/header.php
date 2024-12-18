<?php 
    $array_navbar_1 = [
        ["label" => "Home", "url" => "../controller/home"],
        ["label" => "Shoes", "url" => "../controller/shoes"],
        ["label" => "Clother", "url" => "../controller/clother"],
        ["label" => "Accessories", "url" => "../controller/accessories"],
        ["label" => "About us", "url" => "../controller/aboutus"],
        ["label" => "Collections", "url" => "../controller/collections"],
    ];

    function generateNavbar($navItems,$class) {
        echo "<nav>";
        echo "<ul class='$class'>";
        foreach ($navItems as $item) {
            echo "<li>";
            if (is_array($item)) {
                echo '<a style="text-decoration: none; color: black" href="' . $item["url"] . '">' . $item["label"] . '</a>';
            } else {
                echo '<a href="#">' . $item . '</a>';
            }
            echo '</li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/component/linkbootstrap5.php" ?>
    <?php include   $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/assets/css/header.css.php" ?>
</head>
<body>
    <div class="container">
        <div class="row row1">
            <div style="font-size: 12px; padding-top: 15px" class="col-5">sneakerhome@gmail.com | 84+ 123 456 789</div>
            <div class="col-4 bg-white"></div>
            <div class="col-3 d-flex gap-5">
                <a href="../controller/logincontroller.php"><button>Login</button></a>
                <a href="../controller/registercontroller.php"><button>Register</button></a>
                <div><i class="fa-solid fa-cart-shopping cart"></i></div>
            </div>
        </div> 

        <div class="row">
            <div class="col-2 logo"><img src="../assets/img/Shoe Logo.png" alt=""></div>
            <div class="col-9">
                <?php generateNavbar($array_navbar_1, 'navbar d-flex'); ?>
            </div>
        </div>
    </div>
</body>
</html>