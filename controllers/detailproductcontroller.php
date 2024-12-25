<?php
ini_set('display_errors', 1); // Hiển thị lỗi
error_reporting(E_ALL);

include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/models/detailproductmodel.php';

// Lấy ID từ URL
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

if ($product_id === null || $product_id <= 0) {
    die("Product ID not provided or invalid.");
}

// Lấy thông tin sản phẩm từ Model
$product = getProductDetails($product_id);

// Kiểm tra giá trị của $product
if (!$product) {
    die("Product not found for ID = $product_id");
}


// Gọi View để hiển thị dữ liệu
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/views/detailproductview.php';
?>
