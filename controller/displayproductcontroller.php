<?php
require_once '../database/connect.php';  
require_once '../models/displayproductmodels.php';

 // Kết nối cơ sở dữ liệu


$productModel = new ProductModel($db);
// Truyền dữ liệu sang view
$products = $productModel->getBestSellers();
require '../component/displayproduct.php';  // Truyền biến $products vào file view
?>
