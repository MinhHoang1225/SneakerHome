<?php
require_once './database/connect.php';  
require_once './models/displayproductmodels.php';

 // Kết nối cơ sở dữ liệu

$productModel = new ProductModel($db);

// $categoryId = 0; // Mặc định là lấy tất cả
// if (isset($_GET['category_id'])) {
//     $categoryId = intval($_GET['category_id']); // Lấy category_id từ URL
// }
// // Lấy sản phẩm bán chạy theo category_id
// if ($categoryId == 0) {
//     $products = $productModel->getBestSellers(); // Lấy tất cả sản phẩm bán chạy
// } else {
//     $products = $productModel->getBestSellersByCategory($categoryId); // Lấy theo category_id
// }
// $totalProducts = $productModel->getAllBestSellersCount(); // Có thể cần điều chỉnh hàm này

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

require './component/displayproduct.php';  // Truyền biến $products vào file view
?>

