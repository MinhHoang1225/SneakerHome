<?php
require_once '../controller/searchcontroller.php';

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
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .product { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px; display: flex; align-items: center; }
        .product img { width: 50px; height: 50px; margin-right: 10px; object-fit: cover; }
        .product h3 { margin: 0; color: #007bff; }
        .product p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Search Results</h1>

    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <?php if (!empty($product['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php endif; ?>
                <div>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found for "<strong><?php echo htmlspecialchars($keyword); ?></strong>".</p>
    <?php endif; ?>
</body>
</html>
