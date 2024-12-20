<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/component/linkbootstrap5.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/assets/css/displayproduct.css.php'; 
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 8; // Số sản phẩm hiển thị ban đầu
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0; // Danh mục sản phẩm
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
                                    <button onclick="toggleHeart(this)" style="background-color: transparent; border: none;">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="add-to-cart" data-product-id="<?php echo $row['product_id']; ?>" style="background-color: transparent; border: none;">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                                <a href="/SneakerHome/controller/detailproductcontroller.php?product_id=<?php echo $row['product_id']; ?>" class="text-decoration-none text-dark">
                                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" height="200" width="300">
                                </a>
                                <h5 class="mt-3"><?php echo htmlspecialchars($row['name']); ?></h5>

                                <div class="price"><?php echo number_format($row['price']); ?>  VNĐ</div>
                                <div>
                                    <span class="old-price"><?php echo number_format($row['old_price']); ?>  VNĐ</span>

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
<script>
        function toggleHeart(button) {
            const icon = button.querySelector('i'); // Lấy phần tử <i> bên trong button
            if (icon.classList.contains('fa-regular')) {
                // Nếu trái tim rỗng -> đổi sang trái tim đầy
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                // Nếu trái tim đầy -> đổi lại trái tim rỗng
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        fetch('../models/shoppingcartmodels.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'add_to_cart', product_id: productId, quantity: 1 }) // Giả định user_id = 1
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Thêm vào giỏ hàng thành công!');
            } else {
                alert('Có lỗi xảy ra!');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

    </script>
  