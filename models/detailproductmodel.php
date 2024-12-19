<?php
// detailproductmodel.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/database/connect.php'; // Gọi file kết nối database

function getProductDetails($product_id) {
    $sql = "SELECT product_id,category_id, name, price, old_price, discount, image_url, description, stock, color
            FROM product 
            WHERE product_id = :product_id";

    $conn = connectdb(); // Lấy kết nối từ file database
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 sản phẩm
}

function getRelatedProducts($product_id, $category_id) {
    $conn = connectdb();
    $sql = "SELECT product_id, name, price, old_price, discount, image_url
            FROM product 
            WHERE category_id = :category_id AND product_id != :product_id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);


    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
