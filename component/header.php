<?php 
    $array_navbar_1 = [
        ["label" => "Home", "url" => "/SneakerHome/home"],
        ["label" => "Shoes", "url" => "/SneakerHome/Product/productsCategory?category_id=1"],
        ["label" => "Clothers", "url" => "/SneakerHome/Product/productsCategory?category_id=2"],
        ["label" => "Accessories", "url" => "/SneakerHome/Product/productsCategory?category_id=3"],
        ["label" => "About us", "url" => "/SneakerHome/Home/aboutus"],
        ["label" => "Collections", "url" => "/SneakerHome/Product/favorite"],
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

    <?php include   "./component/linkbootstrap5.php" ?>
    <?php include "./assets/css/header.css.php" ?>

</head>
<body>
    <div class="container">
        <div class="row row1">
            <div style="font-size: 12px; padding-top: 15px" class="col-3">sneakerhome@gmail.com | 84+ 123 456 789</div>
            <div class="col-5 bg-white"></div>
            <div class="col-3 d-flex gap-5 btn-lr">
                <a href="/SneakerHome/User/profile"><i class="fa-solid fa-user-circle profile"></i></a>
                <a href='/SneakerHome/User/login'><button>Login</button></a>
                <a href="/SneakerHome/User/register"><button>Register</button></a>
                <a href="/SneakerHome/ShoppingCart/Cart"><i class="fa-solid fa-cart-shopping cart"></i></a>
                <div class="search-container">
                    <!-- Icon tìm kiếm -->
                    <i class="fa-solid fa-magnifying-glass search-icon" onclick="toggleSearchBox()"></i>

                    <!-- Ô nhập từ khóa -->
                    <div id="search-box-wrapper" class="search-box-wrapper" style="display: none;">
                        <form action="../controllers/search" method="GET">
                            <input type="text" id="search-box" name="keyword" class="search-box" placeholder="Enter keyword..." required />
                        </form>
                    </div>
                </div>

            </div>
        </div> 

        <div class="row">
            <div class="col-2 logo"><img src="/SneakerHome/assets/img/Shoe Logo.png" alt=""></div>
            <div class="col-9">
                <?php generateNavbar($array_navbar_1, 'navbar d-flex'); ?>
            </div>
        </div>
    </div>
</body>
<script>
    function toggleSearchBox() {
        const searchBoxWrapper = document.getElementById('search-box-wrapper');
        // Kiểm tra trạng thái hiển thị của ô nhập
        if (searchBoxWrapper.style.display === "none" || searchBoxWrapper.style.display === "") {
            searchBoxWrapper.style.display = "block"; // Hiển thị ô nhập
            document.getElementById('search-box').focus(); // Tự động focus vào ô nhập
        } else {
            searchBoxWrapper.style.display = "none"; // Ẩn ô nhập
        }
    }

</script>

</html>