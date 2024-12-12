<?php
$db = connectdb();

class ProductModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBestSellers() {
        // Truy vấn SQL
        $sql = "SELECT name, price, old_price, discount, image_url FROM product WHERE is_best_seller = 1";
        
        // Chuẩn bị và thực hiện truy vấn
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        // Kiểm tra nếu có lỗi trong truy vấn
        if ($stmt->errorCode() !== '00000') {
            die("Lỗi truy vấn SQL: " . implode(", ", $stmt->errorInfo()));
        }

        // Mảng để lưu sản phẩm
        $products = [];

        // Lấy tất cả kết quả
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kiểm tra mảng sản phẩm
        if (empty($products)) {
            echo "Không có sản phẩm nào!";
        }

        return $products;
    }
}
?>