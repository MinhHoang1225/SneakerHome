<?php
require_once '../controller/searchcontroller.php';
include "../assets/css/displayproduct.css.php";
// Lấy từ khóa từ URL
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
    <title>Search Results</title>
    <!-- <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .product { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px; display: flex; align-items: center; }
        .product img { width: 50px; height: 50px; margin-right: 10px; object-fit: cover; }
        .product h3 { margin: 0; color: #007bff; }
        .product p { margin: 5px 0; }
    </style> -->
</head>
<body>
    <h1>Search Results</h1>

    <?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="product-card">
                <!-- Icons: Heart & Add to Cart -->
                <div class="icons">
                    <button onclick="toggleHeart(this)" style="background-color: transparent; border: none;">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="add-to-cart" data-product-id="<?php echo $product['product_id']; ?>" style="background-color: transparent; border: none;">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
                <!-- Product Image -->
                <?php if (!empty($product['image_url'])): ?>
                    <a href="/SneakerHome/controller/detailproductcontroller.php?product_id=<?php echo $product['product_id']; ?>" class="text-decoration-none text-dark">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" height="200" width="300">
                    </a>
                <?php endif; ?>
                <!-- Product Name -->
                <h5 class="mt-3"><?php echo htmlspecialchars($product['name']); ?></h5>
                <!-- Product Price -->
                <div class="price"><?php echo number_format($product['price'], 0); ?> VNĐ</div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center">No products found for "<strong><?php echo htmlspecialchars($keyword); ?></strong>".</p>
<?php endif; ?>


</body>
</html>
