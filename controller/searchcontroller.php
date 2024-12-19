<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/database/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/models/searchmodels.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);
    $productModel = new Product();
    $results = $productModel->searchByName($keyword);

    if (!empty($results)) {
        foreach ($results as $product) {
            echo "<div>";
            echo "<p><strong>" . htmlspecialchars($product['name']) . "</strong></p>";
            echo "<p>Giá: " . number_format($product['price'], 3) . " VND</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>Không tìm thấy sản phẩm nào.</p>";
    }
}
include $_SERVER['DOCUMENT_ROOT']. '/SneakerHome/views/searchview.php'
?>
