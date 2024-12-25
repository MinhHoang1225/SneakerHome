<?php
require_once '../database/connect.php';

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
include '../views/searchview.php'
?>
