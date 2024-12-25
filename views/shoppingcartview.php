<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT']. "/SneakerHome/component/linkbootstrap5.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT']. "/SneakerHome/assets/css/shoppingcart.css.php"; ?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']. "/SneakerHome/component/header.php"; ?>

    <div class="container container1 mt-5">
        <h3>Your Shopping Cart</h3>
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
                <?php foreach ($cartItems as $item): ?>
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

        <h4 class="checkout-btn">Total: <span id="cart-total"><?php echo number_format($cartTotal); ?> đ </span></h4>
        <div class="checkout-btn gap-3 pt-3">
            <a href="../controller/homecontroller.php"><button class="btn btn-primary"> <i class="fa-solid fa-arrow-left"></i> Continue buy</button></a>
            <button class="btn btn-primary">Checkout   <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT']. "/SneakerHome/controller/footercontroller.php"; ?>

    <script>
        document.querySelectorAll('.increase-qty, .decrease-qty').forEach(button => {
    button.addEventListener('click', function() {
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

                // Cập nhật tổng tiền của sản phẩm
                const price = parseFloat(row.querySelector('td:nth-child(3)').innerText.replace(/[^\d.]/g, '')); // Loại bỏ ký tự không cần thiết
                const total = price * quantity; // Tính tổng tiền sản phẩm
                const formattedTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);

                // Cập nhật tổng tiền của sản phẩm
                row.querySelector('.product-total').innerText = formattedTotal;

                // Cập nhật tổng tiền giỏ hàng
                const formattedCartTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.total);
                document.getElementById('cart-total').innerText = formattedCartTotal;

                // Hiệu ứng mượt (tuỳ chọn)
                row.classList.add('updated-row');
                setTimeout(() => row.classList.remove('updated-row'), 300);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

document.querySelectorAll('.remove-from-cart').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');

        // Hiển thị xác nhận trước khi xóa
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            fetch('../models/shoppingcartmodels.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'remove_from_cart', product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Xóa sản phẩm thành công!');
                    // Xóa sản phẩm khỏi giao diện
                    this.closest('.col-md-3').remove();
                } else {
                    alert(data.message || 'Có lỗi xảy ra!');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});

    </script>
</body>
</html>