    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sneaker Home</title>    <!-- Bootstrap 5 CSS -->
        <?php include $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/component/linkbootstrap5.php' ?>
        <!-- Custom CSS -->
        <style>
             body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 20px;
    }
    .confirmation-box {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 100%;
        max-width: 600px;
        text-align: center;
        overflow: hidden; /* Prevent content overflow */
    }
    .confirmation-message {
        font-size: 1.5rem;
        color: #28a745;
        margin-top: 20px;
    }
    .order-summary {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 30px;
        margin-top: 40px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .order-summary h4 {
        color: #007bff;
    }
    .total-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: #343a40;
    }
    .product-list {
        max-height: 250px; /* Set a maximum height */
        overflow-y: auto; /* Add vertical scroll if content exceeds max height */
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }
    .product-list ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .product-list li {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .product-list li:last-child {
        border-bottom: none;
    }
    .product-list img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }
    .product-details {
        flex: 1;
        margin-left: 10px;
        overflow: hidden; /* Prevent overflowing text */
        text-overflow: ellipsis; /* Add ellipsis for overflowing text */
        white-space: nowrap; /* Ensure text doesn't wrap */
    }
    .product-details p {
        margin: 0;
        font-size: 0.9rem;
        color: #555;
    }
    .back-to-home {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 30px;
        font-size: 1rem;
        margin-top: 30px;
        text-align: center;
        display: block;
        width: 200px;
        margin-left: auto;
        margin-right: auto;
    }
    .back-to-home:hover {
        background-color: #0056b3;
        text-decoration: none;
    }
        </style>
    </head>
    <body>
        <?php var_dump($_SESSION) ?>
    <div class="confirmation-box">
    <!-- Success message -->
    <i class="fas fa-check-circle fa-5x text-success"></i>
    <h2 class="confirmation-message">Payment Successful!</h2>
    <p class="lead">Thank you for your purchase. Your order is being processed and will be shipped soon.</p>

    <!-- Order Summary -->
    <div class="order-summary">
        <h4>Order Summary</h4>
        <div class="row">
            <div class="col-6">
                <!-- Display Customer Name -->
                <p><strong>Customer Name: <br>
                </strong> <?= htmlspecialchars($username_input) ?></p>
            </div>
            <div class="col-6 text-end">
                <!-- Display Total Price -->
                <p class="total-price">Total: <?= htmlspecialchars(number_format($priceTotal, 0, ',', '.')) ?> đ</p>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <!-- Display Shipping Address -->
            <p><strong>Shipping Address:</strong></p>
            <p><?= htmlspecialchars($address) ?></p>
        </div>
    </div>

    <!-- Product Details -->
    <div class="product-list">
        <h4>Purchased Products</h4>
        <ul>
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <li class="d-flex align-items-center mb-2">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="me-3" width="50" height="50">
                        <div class="product-details">
                            <p><strong><?= htmlspecialchars($product['name']) ?></strong></p>
                            <p>Quantity: <?= htmlspecialchars($product['quantity']) ?></p>
                        </div>
                        <span class="ms-auto"><?php echo number_format($product['price'] * $product['quantity']); ?> đ</span>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>No products found in your order.</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Return to Home Button -->
    <form action="/SneakerHome/Product/clearCart" method="POST">
            <button type="submit" class="btn btn-primary mt-4">Return to Home</button>
        </form>
</div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>
