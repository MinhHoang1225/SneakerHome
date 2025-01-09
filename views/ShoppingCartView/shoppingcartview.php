<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once "./component/linkbootstrap5.php"; ?>
    <?php include "./assets/css/shoppingcart.css.php"; ?>
</head>
<body>
    <?php include "./component/header.php"; ?>

    <h3 class="container">Your Shopping Cart</h3>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr data-product-id="<?php echo $item['product_id']; ?>">
                        <td>
                            <button class="remove-from-cart" data-product-id="<?php echo $item['product_id']; ?>" style="background-color: transparent; border: none;">
                                <i class="fas fa-trash-alt"></i> <!-- Trash icon -->
                            </button>
                        </td>
                        <td><img class='img_product' src="<?php echo $item['image_url']; ?>" alt="Product Image" /></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price']); ?> đ</td>
                        <td class='d-flex'>
                            <div class="ht">
                                <button class="btn btn-sm btn-outline-secondary decrease-qty">-</button>
                            <input type="number" class="form-control d-inline text-center qty-input" value="<?php echo $item['quantity']; ?>" min="1">
                            <button class="btn btn-sm btn-outline-secondary increase-qty">+</button>
                            </div>
                            
                        </td>
                        <td class="product-total"><?php echo number_format($item['price'] * $item['quantity']); ?> đ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        
            <?php if ($cartTotal > 0): ?>
            <h4 class="checkout-btn">Total: <span id="cart-total"><?php echo number_format($cartTotal); ?> đ</span></h4>
        <?php else: ?>
            <h4 class="checkout-btn">No orders found.</h4>
        <?php endif; ?>        <div class="checkout-btn gap-3 pt-3">
            <a href="../Product/productsCategory?category_id=1"><button class="btn btn-primary"> <i class="fa-solid fa-arrow-left"></i> Continue buying</button></a>

            <form action="/SneakerHome/product/checkoutCart" method="POST">
                <?php foreach ($cart as $item): ?>
                    <input type="hidden" name="products[]" value="<?php echo htmlspecialchars($item['product_id']); ?>">
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">Checkout All</button>
            </form>
        </div>
    </div>

    <?php include "./component/footer.php"; ?>
</body>

<script>
document.querySelectorAll('.decrease-qty').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        const input = row.querySelector('.qty-input');
        const productId = row.dataset.productId;
        let quantity = parseInt(input.value) || 1;

        if (quantity > 1) {
            quantity--;
            input.value = quantity;
            updateQuantity(productId, quantity); // Cập nhật qua AJAX
        }
    });
});

document.querySelectorAll('.increase-qty').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        const input = row.querySelector('.qty-input');
        const productId = row.dataset.productId;
        let quantity = parseInt(input.value) || 1;

        quantity++;
        input.value = quantity;
        updateQuantity(productId, quantity); // Cập nhật qua AJAX
    });
});

document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', function () {
        const row = this.closest('tr');
        const productId = row.dataset.productId;
        let quantity = parseInt(this.value) || 1;

        if (quantity < 1) {
            quantity = 1;
            this.value = quantity;
        }
        updateQuantity(productId, quantity); // Cập nhật qua AJAX
    });
});

// Hàm cập nhật số lượng qua AJAX
function updateQuantity(productId, quantity) {
    fetch('/SneakerHome/shoppingcart/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật tổng tiền giỏ hàng
            document.getElementById('cart-total').textContent = data.cartTotal + ' đ';

            // Cập nhật tổng tiền của sản phẩm
            const row = document.querySelector(`tr[data-product-id="${productId}"]`);
            const productTotal = row.querySelector('.product-total');
            productTotal.textContent = data.productTotal + ' đ';
        } else {
            alert(data.error || 'Cart update failed!');
        }
    })
    .catch(error => console.error('Lỗi:', error));
}

// Xóa sản phẩm khỏi giỏ hàng
document.querySelectorAll('.remove-from-cart').forEach(button => {
    button.addEventListener('click', async function () {
        if (confirm('Are you sure you want to remove this product from your cart?')) {
            const productId = this.dataset.productId;

            // Disable button to indicate loading
            this.disabled = true;

            try {
                const response = await fetch('/SneakerHome/shoppingcart/handleRemoveCartItem', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: productId }),
                });

                const data = await response.json();
                if (data.success) {
                    // Remove the product row
                    document.querySelector(`tr[data-product-id="${productId}"]`).remove();

                    // Update cart total
                    document.getElementById('cart-total').textContent = data.cartTotal + ' đ';
                } else {
                    alert(data.error || 'Failed to remove product.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            } finally {
                // Re-enable the button
                this.disabled = false;
            }
        }
    });
});


</script>

</html>
