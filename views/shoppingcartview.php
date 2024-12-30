<?php var_dump($_SESSION) ?>
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
    <div class="container mt-5 of">
       
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
                    <td><button class="remove-from-cart" data-product-id="<?php echo $product['product_id']; ?>" style="background-color: transparent; border: none;">
                            <i class="fas fa-trash-alt"></i> <!-- Biểu tượng xóa -->
                        </button>
                    </td>
                    
                    <td><img class='img_product' src="<?php echo $item['image_url']; ?>" alt="Product Image" /></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($item['price']); ?> đ </td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary decrease-qty">-</button>
                        <input type="text" class="form-control d-inline text-center qty-input" 
                               value="<?php echo number_format($item['quantity']); ?>">
                        <button class="btn btn-sm btn-outline-secondary increase-qty">+</button>
                    </td>
                    <td class="product-total "><?php echo number_format($item['price'] * $item['quantity']); ?> đ </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        
    </div>
    <div class="container">
        <h4 class="checkout-btn">Total: <span id="cart-total"><?php echo number_format($cartTotal); ?> đ </span></h4>
        <div class="checkout-btn gap-3 pt-3">
            <a href="../controllers/home"><button class="btn btn-primary"> <i class="fa-solid fa-arrow-left"></i> Continue buy</button></a>
            <a href="/SneakerHome/product/checkoutBuyNow"><button class="btn btn-primary">Checkout   <i class="fa-solid fa-arrow-right"></i></button></a>

        </div>
    </div>
    
    <?php include "./component/footer.php"; ?>

    <script>    
        document.querySelectorAll('.increase-qty, .decrease-qty').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('tr'); // Lấy hàng hiện tại
        const productId = row.dataset.productId; // ID sản phẩm
        const input = row.querySelector('.qty-input'); // Ô input số lượng
        let quantity = parseInt(input.value); // Giá trị số lượng hiện tại

        // Tăng hoặc giảm số lượng
        quantity = this.classList.contains('increase-qty') ? quantity + 1 : quantity - 1;
        if (quantity < 1) return; // Không cho phép số lượng < 1

        // Gửi request đến server
        fetch('shoppingcartcontroller.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${productId}&quantity=${quantity}`
        })
            .then(response => response.json()) // Chuyển phản hồi thành JSON
            .then(data => {
                if (data.status === 'success') {
                    // Cập nhật số lượng trên giao diện
                    input.value = quantity;

                    // Tính toán và cập nhật tổng tiền của sản phẩm
                    const priceElement = row.querySelector('td:nth-child(3)'); // Giá sản phẩm
                    const totalElement = row.querySelector('.product-total'); // Tổng tiền của sản phẩm
                    const price = parseFloat(priceElement.innerText.replace(/[^\d.]/g, '')); // Lấy giá sản phẩm (loại bỏ ký tự không cần thiết)
                    const total = price * quantity; // Tính tổng tiền sản phẩm

                    // Định dạng số tiền
                    const formattedTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
                    totalElement.innerText = formattedTotal; // Cập nhật tổng tiền sản phẩm

                    // Cập nhật tổng tiền giỏ hàng
                    const cartTotalElement = document.getElementById('cart-total');
                    const formattedCartTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.total);
                    cartTotalElement.innerText = formattedCartTotal; // Cập nhật tổng tiền giỏ hàng

                    // Hiệu ứng mượt mà
                    totalElement.classList.add('updated-qty');
                    setTimeout(() => totalElement.classList.remove('updated-qty'), 300);

                    cartTotalElement.classList.add('updated-qty');
                    setTimeout(() => cartTotalElement.classList.remove('updated-qty'), 300);

                    row.classList.add('updated-row');
                    setTimeout(() => row.classList.remove('updated-row'), 500);
                }
            })
            .catch(error => console.error('Error:', error));
    });
});

    </script>
</body>
</html>