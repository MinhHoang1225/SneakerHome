<?php
$db = connectdb();
    class ProductModel {
        private $db;
        
        public function __construct($db) {
            $this->db = $db;
        }
    

    public function getBestSellers($limit = 8) {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url FROM product WHERE is_best_seller = 1 LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        // Kiểm tra nếu có lỗi trong truy vấn
        if ($stmt->errorCode() !== '00000') {
            die("Lỗi truy vấn SQL: " . implode(", ", $stmt->errorInfo()));
        }
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBestSellers() {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url FROM product WHERE is_best_seller = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    
        // Kiểm tra nếu có lỗi trong truy vấn
        if ($stmt->errorCode() !== '00000') {
            die("Lỗi truy vấn SQL: " . implode(", ", $stmt->errorInfo()));
        }
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllBestSellersCount($categoryId = null) {
        if ($categoryId === null) {
            $sql = "SELECT COUNT(*) FROM product WHERE is_best_seller = 1";
        } else {
            $sql = "SELECT COUNT(*) FROM product WHERE is_best_seller = 1 AND category_id = :category_id";
        }
    
        $stmt = $this->db->prepare($sql);
        if ($categoryId !== null) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }

    public function getBestSellersByCategory($categoryId, $limit = 8) {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url 
                FROM product 
                WHERE is_best_seller = 1 AND category_id = :category_id 
                LIMIT :limit";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    }
    
    
?>