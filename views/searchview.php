<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include './component/linkbootstrap5.php'; ?>
    <?php include './assets/css/displayproduct.css.php'; ?>
</head>
<body>
    <?php include './component/header.php'; ?>
        <h1>Search Results</h1>
        <div class="row" id="product-container">
            <?php if (!empty( $searchResults)) { ?>
                <?php foreach ( $searchResults as $row) {  ?>  
                    <div class="col-md-4 col-lg-3 mb-4">                       
                        <div class="product-card">
                            <div class="icons">
                                <button onclick="toggleHeart(this)" class="add-to-favorite" data-product-id="<?php echo $row['product_id']; ?>" style="background-color: transparent; border: none;">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="add-to-cart" data-product-id="<?php echo $row['product_id']; ?>" style="background-color: transparent; border: none;">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                            <a href="./Product/detailproduct?category_id=<?php echo $categoryId; ?>&product_id=<?php echo $row['product_id']; ?>">
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" height="200" width="300">
                            </a>
                            <h5 class="mt-3"><?php echo htmlspecialchars($row['name']); ?></h5>

                            <div class="price"><?php echo number_format($row['price']); ?> VNĐ</div>
                            <div>
                                <span class="old-price"><?php echo number_format($row['old_price']); ?> VNĐ</span>
                                <span class="discount"><?php echo $row['discount']; ?>% Off</span>
                            </div>
                        </div>
                        
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Không có sản phẩm nào.</p>
            <?php } ?>
        </div>
    </div>

    <?php include './component/footer.php'; ?>  
    <?php include './component/btn_up.php'; ?>
    <script>
        const userId = <?php echo $_SESSION['userId'] ?? 'null'; ?>;
function toggleHeart(button) {
    const productId = button.getAttribute('data-product-id');
    const userId = <?php echo $_SESSION['userId'] ?? 'null'; ?>;

    if (!userId) {
        alert('Bạn phải đăng nhập để thực hiện thao tác này!');
        return;
    }

    console.log('Product ID:', productId, 'User ID:', userId);

    fetch('/SneakerHome/product/favorites', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: userId,
            product_id: productId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
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

