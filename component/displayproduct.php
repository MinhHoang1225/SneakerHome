<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/component/linkbootstrap5.php'; ?>;
<?php include $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/assets/css/displayproduct.css.php'; ?>
<?php
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 8; // Số sản phẩm hiển thị ban đầu
$totalProducts = ($categoryId == 0)
    ? $productModel->getAllBestSellersCount()
    : $productModel->getAllBestSellersCount($categoryId); // Số lượng tổng sản phẩm theo category_id
?>

<body>
    <img src="../assets/img/Offer Banner.png" alt="Offer Banner">
    <div class="container mt-5">
        <h2 class="text-center">BEST SELLER</h2>
        <div class="text-center my-4">
            <a class="mx-3" href="?category_id=0">All</a>
            <a class="mx-3" href="?category_id=1">Shoes</a>
            <a class="mx-3" href="?category_id=2">Clothes</a>
            <a class="mx-3" href="?category_id=3">Accessories</a>
        </div>
        <div class="row" id="product-container">
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
        <?php if ($totalProducts > $limit) { ?>
            <div class="load-more" id="loadMoreBtn">
                <a href="?load_more=true&category_id=<?php echo $categoryId; ?>">LOAD MORE</a>
            </div>
        <?php } ?>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const productContainer = document.getElementById("product-container");
    if (window.location.href.includes("load_more=true") || window.location.href.includes("category_id=")) {
        productContainer.scrollIntoView({ behavior: "smooth" });
    }
});

</script>
