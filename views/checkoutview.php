<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Order Page</title>
    <?php include_once "../component/linkbootstrap5.php"; ?>
    <?php include "../assets/css/checkout.css.php"; ?>
</head>
<body>
<div class="container">
    <div class="row">
        <!-- User Information Form -->
        <div class="col-md-6">
            <h2>User Information</h2>
            <form action="checkoutController.php" method="POST">
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
                    <input class="form-control py-5" placeholder="Note" type="text" name="note"/>
                </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6">
        <div class="order-summary">
            <h2>Order</h2>
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="order-item container">
                        <div class="row">
                            <div class="col-3">
                                <img alt="<?php echo htmlspecialchars($item['name']); ?>" height="80" src="<?php echo htmlspecialchars($item['image_url']); ?>" width="100"/>
                            </div>
                            <div class="col-3">
                            <?php echo htmlspecialchars($item['name']); ?>
                            </div>
                            <div class="col-3">
                            <?php echo number_format($item['price']); ?> VNĐ
                            </div>
                            <div class="col-3">
                            <?php echo htmlspecialchars($quantity) ?>
                            </div>
                        </div>

                
            </div>
        <?php endforeach; ?>
        
        <div class="total-price">
            Total price: 
            <span class="item-price">
                <?php echo number_format($cartTotalCheckOut); ?> VNĐ
            </span>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
<div class="d-flex">
    <div class="back-to-cart">
        <i class="fas fa-arrow-left"></i>
        <a href="../controller/shoppingcartcontroller.php">Shopping cart</a>
    </div>
    <button class="btn btn-payment mt-3" type="submit">
        Payment
    </button>
</div>
    
</div>

        </div>
        </form>
    </div>
</div>
</body>
</html>
