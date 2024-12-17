<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once "../component/linkbootstrap5.php"; ?>
    <?php include "../assets/css/shoppingcart.css.php"; ?>
</head>
<body>
    <div class="container mt-5">
        <h3>Your Shopping Cart</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($cartItems) && !empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>                            
                            <td><img class='img_product'src="<?php echo $item['image_url']; ?>" alt="Product Image" /></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary decrease-qty">-</button>
                                <input type="text" class="form-control d-inline text-center qty-input" 
                                    value="<?php echo $item['quantity']; ?>" style="width: 50px;">
                                <button class="btn btn-sm btn-outline-secondary increase-qty">+</button>
                            </td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <hr>
        <h4 class="checkout-btn">Total: $<?php echo number_format($cartTotal, 2); ?></h4>
        <div class="checkout-btn gap-3 pt-3">
            <button class="btn btn-primary"> <i class="fa-solid fa-arrow-left"></i> Continue buy</button>
            <button class="btn btn-primary">Checkout   <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

    <script>
        document.querySelectorAll('.increase-qty').forEach(button => {
            button.addEventListener('click', function() {
                const qtyInput = this.previousElementSibling;
                let currentQty = parseInt(qtyInput.value);
                if (!isNaN(currentQty)) {
                    qtyInput.value = currentQty + 1;
                }
            });
        });

        document.querySelectorAll('.decrease-qty').forEach(button => {
            button.addEventListener('click', function() {
                const qtyInput = this.nextElementSibling;
                let currentQty = parseInt(qtyInput.value);
                if (!isNaN(currentQty) && currentQty > 1) {
                    qtyInput.value = currentQty - 1;
                }
            });
        });
    </script>
</body>
</html>
