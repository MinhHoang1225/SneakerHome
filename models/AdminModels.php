<?php
require_once "./database/connect.php";

class AdminModel {
    private $db;

    public function __construct() {
        $this->db = connectdb();
    }
    public function getDashboardData() {
        $data = [];
    
        // Lấy số lượng khách hàng
        $sql = "SELECT COUNT(*) as total_customers FROM user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data['total_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_customers'];
    
        // Lấy số lượng sản phẩm
        $sql = "SELECT COUNT(*) as total_products FROM product";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];
    
        // Lấy số lượng đơn hàng
        $sql = "SELECT COUNT(*) as total_orders FROM `order`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

        return $data;
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
    // Sửa sản phẩm
    public function updateProduct($id, $name, $price, $stock, $imagePath) {
        $stmt = $this->db->prepare("UPDATE product SET name = ?, price = ?, stock = ?, image_url = ? WHERE product_id = ?");
        $stmt->execute([$name, $price, $stock, $imagePath, $id]);
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