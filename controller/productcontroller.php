<?php
// Import model
include_once "../models/productmodel.php";

// Lấy category_id từ URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Gọi model để lấy danh sách sản phẩm
$products = getProductsByCategory($category_id);

// Import view
include_once "../views/productview.php";
?>
