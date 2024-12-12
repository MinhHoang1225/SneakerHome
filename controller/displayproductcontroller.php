<?php
require_once '../database/connect.php';  
require_once '../models/displayproductmodels.php';

$db = connectdb(); // Kết nối cơ sở dữ liệu
if (!$db) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}
echo "Kết nối cơ sở dữ liệu thành công!";

$productModel = new ProductModel($db);
// Truyền dữ liệu sang view
$products = $productModel->getBestSellers();
echo "<pre>";
print_r($products);
echo "</pre>";
die(); // Ngăn hiển thị các phần khác để kiểm tra chính xác biến

// Truyền dữ liệu sang view
require_once '../component/displayproduct.php';
?>
