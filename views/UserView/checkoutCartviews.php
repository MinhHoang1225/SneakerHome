<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sneaker Home</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/component/linkbootstrap5.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/assets/css/checkout.css.php"; ?>
</head>
<body>
<div class="container">
    <div class="row">
        <!-- User Information -->
        <div class="col-md-6">
            <h2>User Information</h2>
            <form id="checkoutForm">
                <div class="mb-3">
                    <input class="form-control" placeholder="Fullname" type="text" name="fullname" required/>
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Email" type="email" name="email" required/>
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Address" type="text" name="address" required/>
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Phone number" type="text" name="phone" required/>
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Note" type="text" name="note"/>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6">
            <div class="order-summary">
                <h2>Order</h2>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $item): ?>
                        <div class="order-item container">
                            <div class="row">
                                <div class="col-2">
                                    <img alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                         height="80" 
                                         src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                         width="100"/>
                                </div>
                                <div class="col-6">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </div>
                                <div class="col-3">
                                    <?php echo number_format($item['price']); ?> VNĐ
                                </div>
                                <div class="col-1">
                                    x<?php echo htmlspecialchars($item['quantity']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="total-price">
                        Total price: 
                        <span class="item-price">
                            <?php echo number_format($cartTotal); ?> VNĐ
                        </span>
                    </div>
                <?php else: ?>
                    <p>Your cart is empty.</p>
                <?php endif; ?>
            </div>
            <div class="d-flex gap-5">
                <div class="back-to-cart">
                    <i class="fas fa-arrow-left"></i>
                    <a href="../controllers/shoppingcart">Back to cart</a>
                </div>
                <button id="paymentButton" class="btn btn-payment" style="border: none;">
                    Payment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('paymentButton').addEventListener('click', function () {
        const products = <?php echo json_encode($products); ?>; // Pass products data
        const cartTotal = <?php echo json_encode($cartTotal); ?>; // Pass total price

        fetch('/SneakerHome/product/saveOrderCart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ products: products, totalPrice: cartTotal }),
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                window.location.href = '/SneakerHome/product/checkoutSuccessCart';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch((error) => {
            alert('An unexpected error occurred: ' + error.message);
        });
    });
</script>
</body>
</html>
