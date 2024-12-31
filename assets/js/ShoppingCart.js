document.querySelectorAll('.decrease-qty').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        const input = row.querySelector('.qty-input');
        const productId = row.dataset.productId;
        let quantity = parseInt(input.value) || 1;

        if (quantity > 1) {
            quantity--;
            input.value = quantity;
            updateQuantity(productId, quantity); // Gửi dữ liệu cập nhật qua AJAX
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
        updateQuantity(productId, quantity); // Gửi dữ liệu cập nhật qua AJAX
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
        updateQuantity(productId, quantity); // Gửi dữ liệu cập nhật qua AJAX
    });
});

// Hàm cập nhật số lượng qua AJAX
function updateQuantity(productId, quantity) {
    fetch('/SneakerHome/shoppingcart/updateQuantity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng giá
                document.getElementById('cart-total').textContent = data.cartTotal + ' đ';
                // Cập nhật giá sản phẩm
                const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                const productTotal = row.querySelector('.product-total');
                productTotal.textContent = data.productTotal + ' đ';
            } else {
                alert(data.error || 'Cập nhật thất bại!');
            }
        })
        .catch(error => console.error('Error:', error));
}
