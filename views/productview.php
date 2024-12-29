<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SneakerHome</title>
    <?php include_once "./component/linkbootstrap5.php"; ?>
    <?php include "./assets/css/product.css.php"; ?>
</head>
<body>
    <!-- Include Header -->
    <?php include "./component/header.php"; ?>

    <!-- Danh sách sản phẩm -->
    <div class="product-container container">
        <h2 class="text-center">Product List</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4" style="position: relative">
                    <div class="icons">
                        <!-- <i class="far fa-heart" ></i> -->
                        <button onclick="toggleHeart(this)" class="add-to-favorite" data-product-id="<?php echo $product['product_id']; ?>" style="background-color: transparent; border: none;">
                                        <i class="far fa-heart"></i>
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
    <?php include "./controllers/footercontroller.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '\SneakerHome\component\btn_up.php'; ?>
    <script>
       function toggleHeart(button) {
    const productId = button.getAttribute('data-product-id');
    const userId = <?php echo $_SESSION['user_id'] ?? 'null'; ?>;

    if (!userId) {
        alert('Bạn phải đăng nhập để thực hiện thao tác này!');
        return;
    }

    console.log('Product ID:', productId, 'User ID:', userId);

    fetch('../controllers/favoritecontroller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'toggle_favorite',
            user_id: userId,
            product_id: productId
        })
    })
    .then(response => response.json()) 
    .then(data => {
        console.log('Server response:', data); 

        const icon = button.querySelector('i');

        if (data.success) {
            if (data.is_favorited) {
                icon.classList.remove('far'); 
                icon.classList.add('fas');    
            } else {
                icon.classList.remove('fas'); 
                icon.classList.add('far');    
            }

            alert(data.message);
        } else {
            alert('Có lỗi xảy ra khi xử lý yêu cầu.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi khi xử lý yêu cầu!');
    });
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
