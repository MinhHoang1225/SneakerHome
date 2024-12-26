<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/component/linkbootstrap5.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/assets/css/favorite.css.php'; 
?>
<div class="container">
    <h2>Danh sách yêu thích</h2>
    <div class="row">
        <?php foreach ($favorites as $favorite) { ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="product-card">
                    <div class="icons">
                        <button onclick="toggleHeart(this)" class="add-to-favorite" data-product-id="<?php echo $favorite['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="add-to-cart" data-product-id="<?php echo $favorite['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                    <a href="/SneakerHome/controller/detailproductcontroller.php?product_id=<?php echo $favorite['product_id']; ?>" class="text-decoration-none text-dark">
                        <img src="<?php echo htmlspecialchars($favorite['image_url']); ?>" alt="<?php echo htmlspecialchars($favorite['name']); ?>" height="200" width="300">
                    </a>
                    <h5 class="mt-3"><?php echo htmlspecialchars($favorite['name']); ?></h5>

                    <div class="price"><?php echo number_format($favorite['price']); ?>  VNĐ</div>
                    <div>
                        <span class="old-price"><?php echo number_format($favorite['old_price']); ?>  VNĐ</span>

                        <span class="discount"><?php echo $favorite['discount']; ?>% Off</span>
                    </div>
                </div>          
            </div>
        <?php } ?>
    </div>
</div>


<script>
    function toggleFavorite(productId) {
    const userId = /* Get the logged-in user ID from session */;
    
    // Gửi yêu cầu POST tới server để toggle yêu thích
    fetch('../controller/favoritecontroller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'toggle_favorite',
            user_id: userId,
            product_id: productId
        })
    })
    .then(response => response.json()) // Xử lý phản hồi JSON
    .then(data => {
        if (data.success) {
            alert('Sản phẩm đã được thêm vào danh sách yêu thích!');
            // Cập nhật màu sắc trái tim, ví dụ thay đổi màu hoặc biểu tượng trái tim
            let heartIcon = document.querySelector(`#heart-icon-${productId}`);
            heartIcon.classList.toggle('active'); // Đổi lớp CSS khi thêm yêu thích
        } else {
            alert('Có lỗi xảy ra khi thêm sản phẩm vào yêu thích!');
        }
    })
    .catch(error => console.error('Error:', error));
}

    function removeFavorite(productId) {
    const userId = /* Get the logged-in user ID */;

    fetch('../controller/favoritecontroller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'remove_favorite',
            user_id: userId,
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Sản phẩm đã được xóa khỏi danh sách yêu thích.');
            location.reload(); // Reload the page to refresh the favorites list
        } else {
            alert('Có lỗi xảy ra!');
        }
    })
    .catch(error => console.error('Error:', error));
}

    document.addEventListener('DOMContentLoaded', fetchFavorites); // Load favorites when the page loads
</script>
