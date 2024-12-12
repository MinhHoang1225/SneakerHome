<?php include_once "../component/linkbootstrap5.php"; ?>
<?php include "../assets/css/displayproduct.css.php"; ?>

<body>
    <img src="../assets/img/Offer Banner.png" alt="Offer Banner">
    <div class="container mt-5">
        <h2 class="text-center">BEST SELLER</h2>
        <div class="text-center my-4">
            <a class="mx-3" href="#">All</a>
            <a class="mx-3" href="#">Shoes</a>
            <a class="mx-3" href="#">Clothes</a>
            <a class="mx-3" href="#">Accessories</a>
        </div>
        <div class="row">
            <?php if (!empty($products)) { ?>
                <?php foreach ($products as $row) { ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="product-card">
                            <div class="icons">
                                <i class="far fa-heart"></i>
                                <i class="fas fa-cart-plus"></i>
                            </div>
                            <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>" height="200" width="300">
                            <h5 class="mt-3"><?php echo $row['name']; ?></h5>
                            <div class="price">$<?php echo $row['price']; ?></div>
                            <div>
                                <span class="old-price">$<?php echo $row['old_price']; ?></span>
                                <span class="discount"><?php echo $row['discount']; ?>% Off</span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Không có sản phẩm nào.</p>
            <?php } ?>
        </div>
        <div class="load-more">
            <a href="#">LOAD MORE</a>
        </div>
    </div>
</body>
