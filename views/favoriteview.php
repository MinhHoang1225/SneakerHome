<?php include_once './component/linkbootstrap5.php'; ?> 
<?php include './assets/css/favorite.css.php'; ?> 

<?php include_once './component/header.php'; ?>

<div class="container">
    <h2>Danh sách yêu thích</h2>
    <div class="row">
        <?php
        // Check if favorites are passed and not empty
        if (isset($favorites) && !empty($favorites)):
            foreach ($favorites as $favorite):
        ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="product-card">
                    <div class="icons">
                        <button onclick="toggleHeart(this)" class="add-to-favorite" data-product-id="<?php echo $favorite['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="far fa-heart"></i>
                        </button>
                        <!-- Button thêm vào giỏ -->
                        <button class="add-to-cart" data-product-id="<?php echo $favorite['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                        
                    </div>
                    <a href="./detailproduct?product_id=<?php echo $favorite['product_id']; ?>" >
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

<?php include_once './component/footer.php'; ?>

<script>
function toggleHeart(button) {
    const productId = button.getAttribute('data-product-id');
    const userId = <?php echo $_SESSION['userId'] ?? 'null'; ?>;

    console.log('Product ID:', productId); // Kiểm tra giá trị productId
    console.log('User ID:', userId);

    if (!productId) {
        alert('Không thể lấy Product ID!');
        return;
    }

    if (!userId) {
        alert('Bạn phải đăng nhập để thực hiện thao tác này!');
        return;
    }

    fetch('/SneakerHome/product/removeFavorite', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userId,
            product_id: productId,
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);

        if (data.success) {
            // Xóa sản phẩm khỏi giao diện
            const card = button.closest('.product-card');
            card.parentNode.removeChild(card);

            alert(data.message);
        } else {
            alert(data.message);
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
        const userId = <?php echo $_SESSION['userId'] ?? 'null'; ?>; // Lấy userId từ session PHP
        // const quantity = document.getElementById('quantity').value;

        if (!userId) {
            alert('Bạn phải đăng nhập để thực hiện thao tác này!');
            return;
        }
        console.log('Product ID:', productId, 'User ID:', userId);
        this.disabled = true; // Disable the button to avoid multiple clicks
        // this.textContent = "Adding..."; // Update the button text

        fetch('/SneakerHome/home/addToCart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'add_to_cart',
                product_id: productId,
                quantity: 1,
                user_id: userId // Gửi userId để backend nhận diện người dùng
            })
        })
        .then(response => {
            if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
            return response.json(); // Chuyển phản hồi thành JSON
        })
        .then(data => {
            this.disabled = false; // Re-enable button after response
            // this.textContent = "Add to Cart"; // Reset the text

            if (data.success) {
                alert('Thêm vào giỏ hàng thành công!');
            } else {
                alert(data.message || 'Có lỗi xảy ra!');
            }
        })
        .catch(error => {
            this.disabled = false; // Re-enable button if there's an error
            // this.textContent = "Add to Cart";
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng!');
        });
    });
});
</script>