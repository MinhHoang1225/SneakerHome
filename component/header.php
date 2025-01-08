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
                <?php
                    if (!isset($_SESSION['isLogin']) || !$_SESSION['isLogin']) {
                        echo "
                            <a href='/SneakerHome/User/login'><button>Login</button></a>
                            <a href='/SneakerHome/User/register'><button>Register</button></a>
                        ";
                    } else {
                        echo '
                        <form method="POST" action="/SneakerHome/User/logout">
                            <button type="submit">Logout</button>
                        </form>
                       ';
                    }
                    ?>             
                <a href="/SneakerHome/ShoppingCart/Cart"><i class="fa-solid fa-cart-shopping cart"></i></a>
                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass search-icon" onclick="toggleSearchBox()"></i>

                    <div id="search-box-wrapper" class="search-box-wrapper" style="display: none;">
                        <form action="/SneakerHome/Product/search" method="POST">
                            <input type="text" id="search-box" name="keyword" class="search-box" placeholder="Enter keyword..." required />
                        </form>
                    </div>
                </div>

            </div>
        </div> 

        <div class="row">
            <div class="col-2 logo"><img src="/SneakerHome/assets/img/Shoe Logo.png" alt=""></div>
            <div class="col-9">
                <ul class='d-flex gap-3 navbar pt-5' ">
                    <a href="/SneakerHome/home"><li>Home</li></a>
                    <a href="/SneakerHome/Product/productsCategory?category_id=1"><li>Shoes</li></a>
                    <a href="/SneakerHome/Product/productsCategory?category_id=2"><li>Clothers</li></a>
                    <a href="/SneakerHome/Product/productsCategory?category_id=3"><li>Accessories</li></a>
                    <a href="/SneakerHome/Home/aboutus"><li>About us</li></a>
                    <a href="/SneakerHome/Product/favorite"><li>Collections</li></a>
                </ul>
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