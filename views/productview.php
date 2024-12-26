<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SneakerHome</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/linkbootstrap5.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/assets/css/product.css.php"; ?>
</head>
<body>
    <!-- Include Header -->
    <?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/header.php"; ?>

    <!-- Danh sách sản phẩm -->
    <div class="product-container container">
        <h2 class="text-center">Product List</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4" style="position: relative">
                    <div class="icons">
                        <!-- <i class="far fa-heart" ></i> -->
                        <button onclick="toggleHeart(this)" style="background-color: transparent; border: none;">
                            <i class="far fa-heart" ></i> <!-- Tăng kích thước trái tim -->
                        </button>
                        <button class="add-to-cart" data-product-id="<?php echo $product['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="fas fa-cart-plus"></i>
                        </button>

                    </div>
                    <div class="card h-300"href="detailproduct?product_id=<?php echo $product['product_id']; ?>" >
    <!-- Hình ảnh sản phẩm -->
    <a href="detailproduct?product_id=<?php echo $product['product_id']; ?>" >
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
        alt="<?php echo htmlspecialchars($product['name']); ?>" 
        class="card-img-top">
    </a>

    <div class="card-body text-center">
        <!-- Tên sản phẩm -->
        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>

        <!-- Hiển thị giá -->
        <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
            <p class="price">
                <span class="new-price  fw-bold">
                    <?php echo number_format($product['price']); ?>  VNĐ
                </span>
                <div>
                    <span class="old-price text-muted text-decoration-line-through">
                        <?php echo number_format($product['old_price']); ?>  VNĐ
                    </span>
                    <span class="discount">
                        <?php echo number_format($product['discount']); ?>% Off
                    </span>
                </div> <!-- Thẻ này đóng đúng -->
            </p> <!-- Thẻ này đóng đúng -->
        <?php else: ?>
            <p class="price fw-bold">
                <?php echo number_format($product['price']); ?>VNĐ
            </p>
        <?php endif; ?>

    </div> <!-- Thẻ card-body -->
</div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/controllers/footercontroller.php"; ?>
    <script>
        function toggleHeart(button) {
            const icon = button.querySelector('i'); // Lấy phần tử <i> bên t rong button
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
            body: JSON.stringify({ action: 'add_to_cart', product_id: productId, quantity: 1 }) // Không cần gửi user_id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Thêm vào giỏ hàng thành công!');
            } else {
                alert(data.message || 'Có lỗi xảy ra!');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});


    </script>
</body>
</html>
