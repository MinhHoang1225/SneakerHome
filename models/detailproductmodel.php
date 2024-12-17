<?php
// detailproductmodel.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/database/connect.php'; // Gọi file kết nối database

function getProductDetails($product_id) {
    $sql = "SELECT product_id, name, price, old_price, discount, image_url, description, stock, color
            FROM product 
            WHERE product_id = :product_id";

    $conn = connectdb(); // Lấy kết nối từ file database
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 sản phẩm
}


function getRelatedProducts($limit = 4) {
    $conn = connectdb();
    $stmt = $conn->prepare("SELECT * FROM product LIMIT :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
