<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sneaker Home</title>
    <?php include_once  $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/linkbootstrap5.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/assets/css/checkout.css.php"; ?>
</head>
<body>
    <?php var_dump($_SESSION) ?>
<div class="container">
    <div class="row">
        <!-- User Information Form -->
        <div class="col-md-6">
            <h2>User Information</h2>
            <form action="./checkoutSuccessBuyNow" method="POST">
                <div class="mb-3">
                    <input class="form-control" placeholder="Fullname" type="text" name="fullname" required />
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Email" type="email" name="email" required />
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Address" type="text" name="address" required />
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Phone number" type="text" name="phone" required />
                </div>
                <div class="mb-3">
                    <input class="form-control py-5" placeholder="Note" type="text" name="note" />
                </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6">
            <div class="order-summary">
                <h2>Order</h2>
                <?php if (!empty($cartItems)) : ?>
                    <?php foreach ($cartItems as $item) : ?>
                        <div class="order-item container">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="100" height="80">
                                </div>
                                <div class="col-6">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </div>
                                <div class="col-3">
                                    <?php echo number_format($item['price']); ?> VNĐ
                                </div>
                                <div class="col-1">
                                    x<?php echo htmlspecialchars($item['quantity']); ?> <!-- Hiển thị số lượng -->
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="total-price">
                        Total price: <span class="item-price"><?php echo number_format($cartTotalCheckOut); ?> VNĐ</span>
                    </div>
                <?php else : ?>
                    <p>Your cart is empty.</p>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="back-to-cart">
                        <i class="fas fa-arrow-left"></i>
                        <a href="../controllers/shoppingcart">Shopping cart</a>
                    </div>

                    <!-- Nút Payment trong form -->
                    <button onclick="toggleHeart(this)" class="btn btn-payment" 
                        type="button" 
                        data-product-id="<?php echo $item['product_id']; ?>" 
                        style=" border: none;">
                        Payment
                </button>
<?php var_dump($item['product_id']) ?>

                </div>
            </div>
        </div>
        </form> <!-- Đóng form tại đây -->
    </div>
</div>
       <script>
        function toggleHeart(button) {
    const productId = button.getAttribute('data-product-id');
    const quantity = 1; // Mặc định số lượng (hoặc thay đổi theo logic)
    if (!productId) {
        alert('Product ID is missing.');
        return;
    }

    fetch('/SneakerHome/product/saveOrder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert('Order saved successfully! Order ID: ' + data.order_id);
                location.reload(); // Refresh để cập nhật giao diện
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
        });
}

       </script>             
</body>
</html>
