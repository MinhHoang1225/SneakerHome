<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Product Page</title>
    <?php include_once "../component/linkbootstrap5.php"; ?>
    <?php include "../assets/css/detailproduct.css.php"; ?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/component/header.php'; ?>
<?php
if ($product): ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Hình ảnh sản phẩm -->
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <!-- Thông tin sản phẩm -->
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="price">
                    <span class="new-price"><?php echo number_format($product['price']); ?>  VNĐ</span>
                    <span class="old-price text-muted"><?php echo number_format($product['old_price']); ?>  VNĐ</span>
                </p>
                <p class="discount"><?php echo $product['discount']; ?>% Off</p>
                <p class="availability">
                    Availability: <?php echo $product['stock'] > 0 ? 'In stock' : 'Out of stock'; ?>
                </p>
                <p class="color">Color: <?php echo htmlspecialchars($product['color']); ?></p>
                <p class="description">Description: <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <!-- Chọn Quantity -->
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?php echo $product['stock']; ?>">

                <!-- Nút thêm vào giỏ hàng -->
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    <input type="hidden" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>">
                    <input type="hidden" name="size" id="selected_size" value="S">
                    <input type="hidden" name="color" value="<?php echo htmlspecialchars($product['color']); ?>">

                    <div class="d-flex align-items-center mt-3">
                        <!-- Nút Add to Cart -->
                        <button type="submit" class="btn btn-sm btn-primary me-2" >
                        <i class="fas fa-cart-plus"></i>
                            Add to Cart
                        </button>

                        <!-- Nút Trái Tim -->
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="toggleHeart(this)">
                            <i class="fa-regular fa-heart" style="font-size: 20px;"></i> <!-- Tăng kích thước trái tim -->
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<!-- Sản phẩm liên quan -->
<div class="container mt-5">
    <h3 class="content">Related Products</h3>
    <div class="row">
        <?php 
        // Lấy sản phẩm liên quan từ model
        $related_products = getRelatedProducts($product['product_id'], $product['category_id']); 
        foreach ($related_products as $related_product): ?>
            <div class="col-md-3 mb-4" style="position: relative">
                <div class="icons">
                    <!-- <i class="far fa-heart" ></i> -->
                    <button onclick="toggleHeart(this)" style="background-color: transparent; border: none;">
                        <i class="far fa-heart" ></i> <!-- Tăng kích thước trái tim -->
                    </button>
                    <i class="fas fa-cart-plus"></i>
                </div>
                <div class="card h-300"href="detailproductcontroller.php?product_id=<?php echo $related_product['product_id']; ?>" >
                    <!-- Hình ảnh sản phẩm -->
                    <a href="detailproductcontroller.php?product_id=<?php echo $related_product['product_id']; ?>" >
                        <img src="<?php echo htmlspecialchars($related_product['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($related_product['name']); ?>" 
                         class="card-img-top">
                    </a>
                    

                    <div class="card-body text-center">
                        <!-- Tên sản phẩm -->
                        <h5 class="card-title"><?php echo htmlspecialchars($related_product['name']); ?></h5>

                        <!-- Hiển thị giá -->
                        <?php if (!empty($related_product['old_price']) && $related_product['old_price'] > $related_product['price']): ?>
                            <p class="price">
                                <span class="new-price  fw-bold">
                                    <?php echo number_format($related_product['price']); ?>  VNĐ
                                </span>
                                <div>
                                    <span class="old-price text-muted text-decoration-line-through">
                                        <?php echo number_format($related_product['old_price']); ?>  VNĐ
                                    </span>
                                    <span class="discount">
                                        <?php echo number_format($related_product['discount']); ?>% Off
                                    </span>
                            </div>
                                
                            </p>
                        <?php else: ?>
                            <p class="price fw-bold">
                                <?php echo number_format($related_product['price']); ?>VNĐ
                            </p>
                        <?php endif; ?>
                            
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php else: ?>
    <p>Product details not available.</p>
<?php endif; ?>

    <script>
        function toggleHeart(button) {
            const icon = button.querySelector('i'); // Lấy phần tử <i> bên trong button
            if (icon.classList.contains('fa-regular')) {
                // Nếu trái tim rỗng -> đổi sang trái tim đầy
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                // Nếu trái tim đầy -> đổi lại trái tim rỗng
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        }
    </script>
</body>
</html>
