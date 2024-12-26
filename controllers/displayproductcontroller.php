<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/database/connect.php';  

require_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/models/ProductModels.php';

 // Kết nối cơ sở dữ liệu

$productModel = new ProductModel($db);

// Lấy tham số từ URL
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 8;

// Kiểm tra trạng thái LOAD MORE
if (isset($_GET['load_more']) && $_GET['load_more'] === 'true') {
    // LOAD MORE -> Lấy toàn bộ sản phẩm
    $products = ($categoryId == 0)
        ? $productModel->getAllBestSellers()
        : $productModel->getBestSellersByCategory($categoryId);
} else {
    // Hiển thị sản phẩm giới hạn
    $products = ($categoryId == 0)
        ? $productModel->getBestSellers($limit)
        : $productModel->getBestSellersByCategory($categoryId, $limit);
}

// Đếm tổng sản phẩm
$totalProducts = ($categoryId == 0)
    ? $productModel->getAllBestSellersCount()
    : $productModel->getAllBestSellersCount($categoryId);

require $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/component/displayproduct.php';  // Truyền biến $products vào file view
?>

