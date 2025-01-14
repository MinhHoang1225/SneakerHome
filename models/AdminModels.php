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

    public function getProductsByCategory() {
        $data = [];
        for ($i = 1; $i <= 3; $i++) {
            $sql = "SELECT COUNT(*) as total_products FROM product WHERE category_id = :category_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['category_id' => $i]);
            $data[] = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];
        }
        return $data;
    }

    public function getOrdersByDate() {
        $sql = "SELECT DATE(order_date) as order_date, SUM(total_amount) as total_amount 
                FROM `order` 
                GROUP BY DATE(order_date) 
                ORDER BY order_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductsByCategoryForLast4Weeks() {
        $sql = "SELECT WEEK(order_date) as week_number, p.category_id, COUNT(*) as total_products
                FROM `order` o
                JOIN orderitem od ON o.order_id = od.order_id
                JOIN product p ON od.product_id = p.product_id
                WHERE order_date >= CURDATE() - INTERVAL 4 WEEK
                GROUP BY WEEK(order_date), p.category_id
                ORDER BY WEEK(order_date) ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOrdersPerWeekForLast4Weeks() {
        $sql = "SELECT WEEK(order_date) as week_number, COUNT(*) as total_orders
                FROM `order`
                WHERE order_date >= CURDATE() - INTERVAL 4 WEEK
                GROUP BY WEEK(order_date)
                ORDER BY WEEK(order_date) ASC";
        $stmt = $this->db->prepare($sql);
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
    // Lấy thông tin sản phẩm theo id 
    public function getProductById($productId) {
        $stmt = $this->db->prepare("SELECT *FROM product p WHERE p.product_id = :productId");
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function cancelOrder($orderId) {
        $query = "SELECT * FROM `order` WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false;  
        }

        $query = "UPDATE `order` SET status = 'cancelled' WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);

        return $stmt->execute();  
    }

    public function completeOrder($orderId) {
        $query = "SELECT * FROM `order` WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false;  
        }
        $query = "UPDATE `order` SET status = 'completed' WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);

        return $stmt->execute();  
    }
       // Hàm tìm kiếm tên người dùng
    public function searchByName($keyword) {
        $query = "SELECT * FROM user WHERE `name` LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $keyword = "%".$keyword."%";  
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }
    public function searchProductByName($keyword) {
        $sql = "SELECT * FROM product WHERE name LIKE ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}