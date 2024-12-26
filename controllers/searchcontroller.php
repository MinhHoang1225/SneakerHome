<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/database/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/models/ProductModels.php';

function searchProducts($keyword) {
    $db = connectdb();
    try {
        // Truy vấn để lấy thông tin đầy đủ của sản phẩm
        $query = "SELECT product_id, name, price, old_price, discount, image_url 
                  FROM product 
                  WHERE name LIKE :keyword";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Trả về toàn bộ kết quả dưới dạng mảng kết hợp
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Ghi log lỗi hoặc in ra thông báo khi có vấn đề
        error_log("Database Error: " . $e->getMessage());
        return [];
    }
}
include $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/views/searchview.php'
?>
