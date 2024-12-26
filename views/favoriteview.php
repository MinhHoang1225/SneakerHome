<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/component/linkbootstrap5.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/assets/css/favorite.css.php'; 
?> 
<div class="container">
    <h2>Danh sách yêu thích</h2>
    <div class="row">
        <?php
        // Lấy danh sách yêu thích từ controller
        if (isset($favorites) && !empty($favorites)):
            foreach ($favorites as $favorite):
        ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="product-card">
                    <div class="icons">

                        <!-- Button thêm vào giỏ -->
                        <button class="add-to-cart" data-product-id="<?php echo $favorite['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                    <a href="/SneakerHome/controllers/detailproduct?product_id=<?php echo $favorite['product_id']; ?>" class="text-decoration-none text-dark">
                        <img src="<?php echo htmlspecialchars($favorite['image_url']); ?>" alt="<?php echo htmlspecialchars($favorite['name']); ?>" height="200" width="300">
                    </a>
                    <h5 class="mt-3"><?php echo htmlspecialchars($favorite['name']); ?></h5>
                    <div class="price"><?php echo number_format($favorite['price']); ?> VNĐ</div>
                    <div>
                        <span class="old-price"><?php echo number_format($favorite['old_price']); ?> VNĐ</span>
                        <span class="discount"><?php echo $favorite['discount']; ?>% Off</span>
                    </div>
                </div>          
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p>Hiện tại không có sản phẩm nào trong danh sách yêu thích của bạn.</p>
        <?php endif; ?>
    </div>
</div>
<script>
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        fetch('../models/shoppingcartmodels.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'add_to_cart', product_id: productId, quantity: 1 }) 
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