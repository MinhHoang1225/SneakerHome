<?php 
    $array_navbar_1 = [
        ["label" => "Home", "url" => "../controllers/home"],
        ["label" => "Shoes", "url" => "../controllers/product?category_id=1"],
        ["label" => "Clothers", "url" => "../controllers/product?category_id=2"],
        ["label" => "Accessories", "url" => "../controllers/product?category_id=3"],
        ["label" => "About us", "url" => "../controllers/aboutus"],
        ["label" => "Collections", "url" => "../controllers/product"],
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

    <?php include_once $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/linkbootstrap5.php" ?>
    <?php include   $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/assets/css/header.css.php" ?>

</head>
<body>
    <div class="container">
        <div class="row row1">
            <div style="font-size: 12px; padding-top: 15px" class="col-3">sneakerhome@gmail.com | 84+ 123 456 789</div>
            <div class="col-5 bg-white"></div>
            <div class="col-3 d-flex gap-5">
                <a href="../controllers/profile"><i class="fa-solid fa-user-circle profile"></i></a>
                <a href="../controllers/login"><button>Login</button></a>
                <a href="../controllers/register"><button>Register</button></a>
                <a href="../controllers/shoppingcart"><i class="fa-solid fa-cart-shopping cart"></i></a>
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
            <div class="col-2 logo"><img src="../assets/img/Shoe Logo.png" alt=""></div>
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