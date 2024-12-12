<?php
    class ProductModel {
        private $db;
    
        public function __construct($db) {
            $this->db = $db;
        }
    
        public function getBestSellers() {
            $sql = "SELECT name, price, old_price, discount, image_url FROM product WHERE is_best_seller = 1";
            $result = $this->db->query($sql);
    
            // Kiểm tra nếu có lỗi trong truy vấn
            if (!$result) {
                die("Lỗi truy vấn SQL: " . $this->db->error);
            }
    
            // Mảng để lưu sản phẩm
            $products = [];
    
            // Kiểm tra xem có dữ liệu không
            if ($result->num_rows > 0) {
                // Lặp qua kết quả truy vấn
                while ($row = $result->fetch_assoc()) {
                    // Thêm sản phẩm vào mảng
                    $products[] = $row;
                }
            }
    
            var_dump($result); // Kiểm tra kết quả truy vấn
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    var_dump($row); // Kiểm tra từng dòng dữ liệu
                }
            }
            // Kiểm tra mảng sản phẩm
            if (empty($products)) {
                echo "Không có sản phẩm nào!";
            }
    
            return $products;
        }
    }
    
    
?>