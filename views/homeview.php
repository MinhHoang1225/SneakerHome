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
    <?php var_dump($_SESSION) ?>
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <!-- Indicators/Dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./assets/img/banner2.jpg" class="d-block w-100" style="height: 600px;" alt="Product 1">
            </div>
            <div class="carousel-item">
                <img src="./assets/img/banner1.jpg" class="d-block w-100" style="height: 600px;" alt="Product 2">
            </div>
            <div class="carousel-item">
                <img src="./assets/img/banner3.jpg" class="d-block w-100" style="height: 600px;" alt="Product 3">
            </div>
        </div>
    </div>

    <!-- Best Sellers -->
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
                <?php foreach ($products as $row) {  ?>  
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

        <!-- Load More Button -->
        <?php if ($totalProducts > $limit) { ?>
            <div class="load-more" id="loadMoreBtn">
                <a href="?load_more=true&category_id=<?php echo $categoryId; ?>" class="btn btn-primary">LOAD MORE</a>
            </div>
        <?php } ?>
    </div>

    <?php include './component/footer.php'; ?>  
    <?php include './component/btn_up.php'; ?>
<script>
function toggleHeart(button) {
    const productId = button.getAttribute('data-product-id');
    const userId = <?php echo $_SESSION['userId'] ?? 'null'; ?>;

    if (!userId) {
        alert('Bạn phải đăng nhập để thực hiện thao tác này!');
        return;
    }

    console.log('Product ID:', productId, 'User ID:', userId);

    fetch('/SneakerHome/home/favorite', {
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

