<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/database/connect.php'; // Gọi file kết nối database

// Lấy danh sách sản phẩm theo category_id
function getProductsByCategory($category_id = null) {
    $conn = connectdb();
    if ($category_id) {
        $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("SELECT * FROM product");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
