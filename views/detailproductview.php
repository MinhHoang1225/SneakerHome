<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sneaker Home</title>
    <?php include_once "./component/linkbootstrap5.php"; ?>
    <?php include "./assets/css/detailproduct.css.php"; ?>
</head>
<body>
<?php include  './component/header.php'; ?>
<?php if ($product): ?>
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            
            <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            
            <h2><?= htmlspecialchars($product['name']); ?></h2>
            <p class="price">
                <span class="new-price"><?= number_format($product['price']); ?> VNĐ</span>
                <span class="old-price text-muted"><?= number_format($product['old_price']); ?> VNĐ</span>
            </p>
            <p class="discount"><?= $product['discount']; ?>% Off</p>
            <p class="availability">
                Availability: <?= $product['stock'] > 0 ? 'In stock' : 'Out of stock'; ?>
            </p>
            <p class="color">Color: <?= htmlspecialchars($product['color']); ?></p>
            <p class="description">Description: <?= nl2br(htmlspecialchars($product['description'])); ?></p>

            <!-- Chọn Quantity -->
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?= $product['stock']; ?>">
            <!-- Nút thêm vào giỏ hàng -->
            <form action="/SneakerHome/Product/checkoutBuyNow" method="GET">
                <input type="hidden" name="action" value="buy_now">
                <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                <input type="hidden" name="quantity" id="hidden-quantity" value="1">
                
                <div class="d-flex align-items-center mt-3">
                    <button type="button" class="add-to-cart" data-product-id="<?= $product['product_id']; ?>" style="border: none;">
                        <i class="fas fa-cart-plus"></i>
                        Add to Cart
                    </button>

                    <a href="/SneakerHome/Product/checkoutBuyNow?product_id=<?php echo $product['product_id']; ?>&quantity=" 
                        onclick="return updateQuantity('<?php echo $product['product_id']; ?>');">
                        <button type="submit" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-shopping-bag"></i>
                            Buy Now
                        </button>
                        </a>
                    
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Sản phẩm liên quan -->
    <div class="container mt-5">
    <h3 class="content">Related Products</h3>
    <div class="row">
        <?php if (!empty($related_products)) { ?>
            <?php foreach ($related_products as $related_product) { ?>
                <div class="col-md-3 mb-4" style="position: relative">
                    <div class="icons">
                        <button onclick="toggleHeart(this)" class="add-to-favorite" data-product-id="<?php echo $related_product['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="far fa-heart"></i>
                        </button>
                        <button onclick="addToCart(this)" class="add-to-cart" data-product-id="<?php echo $related_product['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                    <div class="card h-300">
                        
                        <a href="detailproduct?product_id=<?php echo $related_product['product_id']; ?>" data-product-id=<?php echo $related_product['product_id']; ?>>
                            <img src="<?php echo htmlspecialchars($related_product['image_url']); ?>" alt="<?php echo htmlspecialchars($related_product['name']); ?>" class="card-img-top">
                        </a>
                        <div class="card-body text-center">
                            
                            <h5 class="card-title"><?php echo htmlspecialchars($related_product['name']); ?></h5>

                            
                            <?php if (!empty($related_product['old_price']) && $related_product['old_price'] > $related_product['price']) { ?>
                                <p class="price">
                                    <span class="new-price fw-bold"><?php echo number_format($related_product['price']); ?> VNĐ</span>
                                    <div>
                                        <span class="old-price text-muted text-decoration-line-through"><?php echo number_format($related_product['old_price']); ?> VNĐ</span>
                                        <span class="discount"><?php echo number_format($related_product['discount']); ?>% Off</span>
                                    </div>
                                </p>
                            <?php } else { ?>
                                <p class="price fw-bold"><?php echo number_format($related_product['price']); ?> VNĐ</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No related products available.</p>
        <?php } ?>
    </div>
</div>

<?php else: ?>
    <p>Product details not available.</p>
<?php endif; ?>
<?php include  './component/footer.php'; ?>
<script>
function toggleHeart(button) {
    const productId = button.getAttribute('data-product-id');
    const userId = <?php echo $_SESSION['userId'] ?? 'null'; ?>;

    if (!userId) {
        alert('Bạn phải đăng nhập để thực hiện thao tác này!');
        return;
    }

    console.log('Product ID:', productId, 'User ID:', userId);

    fetch('/SneakerHome/product/favorite', {
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
function updateQuantity(productId) {
    const quantityInput = document.getElementById('quantity');
    const quantity = quantityInput ? quantityInput.value : 1; 
    window.location.href = `/SneakerHome/product/checkoutBuyNow?product_id=${productId}&quantity=${quantity}`;
    return false; 
}
function addToCart(button) {
    var productId = button.getAttribute("data-product-id");
    echo json_encode($response);
    header('Content-Type: application/json');
    fetch('/SneakerHome/shoppingcart/addToCart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1,
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json(); // Nếu phản hồi không phải JSON, đoạn này sẽ ném lỗi
    })
    .then(data => {
        if (data.success) {
            alert("Sản phẩm đã được thêm vào giỏ hàng!");
            updateCartIcon();
        } else {
            alert("Có lỗi xảy ra, vui lòng thử lại.");
        }
    })
    .catch(error => {
        console.error("Lỗi khi thêm sản phẩm vào giỏ hàng:", error);
        alert("Có lỗi xảy ra, vui lòng thử lại.");
    });


}

</script>

</body>
</html>
