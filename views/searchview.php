<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/controllers/searchcontroller.php";
include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/assets/css/displayproduct.css.php";
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$products = [];

if (!empty($keyword)) {
    $products = searchProducts($keyword);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/linkbootstrap5.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/assets/css/product.css.php"; ?>
    <title>Sneaker Home</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/header.php"; ?>

<div class="product-container container">
    <h2 class="text-center">Search Results</h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3 mb-4" style="position: relative">
                <div class="icons">
                    <button onclick="toggleHeart(this)" style="background-color: transparent; border: none;">
                        <i class="far fa-heart" ></i> 
                    </button>
                    <button class="add-to-cart" data-product-id="<?php echo $product['product_id']; ?>" style="background-color: transparent; border: none;">
                        <i class="fas fa-cart-plus"></i>
                    </button>

                </div>
                <div class="card h-300"href="detailproductcontroller.php?product_id=<?php echo $product['product_id']; ?>" >
<a href="detailproduct?product_id=<?php echo $product['product_id']; ?>" >
    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
    alt="<?php echo htmlspecialchars($product['name']); ?>" 
    class="card-img-top">
</a>

<div class="card-body text-center">
    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
    <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
        <p class="price">
            <span class="new-price  fw-bold">
                <?php echo number_format($product['price']); ?>  VNĐ
            </span>
            <div>
                <span class="old-price text-muted text-decoration-line-through">
                    <?php echo number_format($product['old_price']); ?>  VNĐ
                </span>
                <span class="discount">
                    <?php echo number_format($product['discount']); ?>% Off
                </span>
            </div> 
        </p> 
    <?php else: ?>
        <p class="price fw-bold">
            <?php echo number_format($product['price']); ?>VNĐ
        </p>
    <?php endif; ?>

</div> 
</div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/component/footer.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/models/btn_up.php"; ?>


<script>
        function toggleHeart(button) {
            const icon = button.querySelector('i'); 
            if (icon.classList.contains('fa-regular')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        fetch('../models/shoppingcartmodels.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'add_to_cart', product_id: productId, quantity: 1 }) 
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Thêm vào giỏ hàng thành công!');
            } else {
                alert(data.message || 'Có lỗi xảy ra!');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});


</script>

</body>
</html>
