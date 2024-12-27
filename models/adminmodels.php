<?php
require_once $_SERVER['DOCUMENT_ROOT']. "/SneakerHome/database/connect.php";

class Model {
    private $db;

    public function __construct() {
        $this->db = connectdb();
    }

    // Lấy danh sách khách hàng
    public function getCustomers() {
        $stmt = $this->db->prepare("SELECT * FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách sản phẩm
    public function getProducts() {
        $stmt = $this->db->prepare("SELECT * FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách đơn hàng
    public function getOrders() {
        $stmt = $this->db->prepare("SELECT * FROM `order`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm mới
    public function addProduct($name, $price, $stock, $imagePath) {
        $stmt = $this->db->prepare("INSERT INTO product (name, price, stock, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $stock, $imagePath]);
    }
    public function getProductById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM product WHERE product_id = :id");
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            $stmt->execute();
            
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                return $product; 
            } else {
                return null; 
            }
        } catch (PDOException $e) {
            error_log("Error fetching product by ID: " . $e->getMessage());
            return null;
        }
    }
    
    // Cập nhật thông tin sản phẩm
    public function updateProduct($id, $name, $price, $stock,$imagePath) {
        $stmt = $this->db->prepare("UPDATE product SET name = ?, price = ?, stock = ?, imagePath = ? WHERE product_id = ?");
        return $stmt->execute([$id, $name, $price, $stock, $imagePath]);
    }
    
    // Xóa sản phẩm 
    public function deleteProduct($product_id) {
        $stmt = $this->db->prepare("DELETE FROM product WHERE product_id = ?");
        $stmt->execute([$product_id]);
    }
    
    // Lấy danh sách đơn hàng theo khách hàng
    public function getOrdersByUser() {
        $stmt = $this->db->prepare("SELECT o.order_id, u.name, u.email FROM `order` o JOIN user u ON o.user_id = u.user_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách đơn hàng theo trạng thái
    public function getOrdersByStatus($status) {
        $stmt = $this->db->prepare("SELECT o.order_id, u.name, o.order_date, o.status FROM `order` o JOIN user u ON o.user_id = u.user_id WHERE o.status = ?");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
