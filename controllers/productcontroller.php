<?php
// Import model
include_once $_SERVER['DOCUMENT_ROOT']. "/SneakerHome/models/ProductModels.php";

// Lấy category_id từ URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Gọi model để lấy danh sách sản phẩm
$products = getProductsByCategory($category_id);

// Import view
include_once $_SERVER['DOCUMENT_ROOT']. "/SneakerHome/views/productview.php";

// include $_SERVER['DOCUMENT_ROOT'] . '\SneakerHome\models\btn_up.php';

?>