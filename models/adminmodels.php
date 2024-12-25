<?php
require_once '../database/connect.php';

class AdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Thêm sản phẩm
    public function addProduct($name, $price, $stock, $image) {
        // Kiểm tra và tải lên hình ảnh nếu có
        if (!empty($image)) {
            $target_dir = "../assets/img/";
            $target_file = $target_dir . basename($image["name"]);
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Thêm sản phẩm vào CSDL
                $sql = "INSERT INTO products (name, price, stock, img) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$name, $price, $stock, $image["name"]]);
            }
        }
        return false;  // Trả về false nếu không có hình ảnh hoặc không tải lên được
    }

    // Sửa sản phẩm
    public function editProduct($product_id, $name, $price, $stock, $image = null) {
        // Nếu có hình ảnh mới
        if ($image) {
            $target_dir = "../assets/img/";
            $target_file = $target_dir . basename($image["name"]);
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $sql = "UPDATE products SET name = ?, price = ?, stock = ?, img = ? WHERE product_id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$name, $price, $stock, $image["name"], $product_id]);
            }
        } else {
            // Nếu không có hình ảnh mới
            $sql = "UPDATE products SET name = ?, price = ?, stock = ? WHERE product_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$name, $price, $stock, $product_id]);
        }
        return false;  // Trả về false nếu không có thay đổi
    }

    // Xóa sản phẩm
    public function deleteProduct($product_id) {
        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$product_id]);
    }

    // Lấy danh sách sản phẩm
    public function getProducts() {
        $sql = "SELECT * FROM products";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách người dùng
    public function getUsers() {
        $sql = "SELECT * FROM users";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy người dùng theo ID
    public function getUserById($user_id) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật thông tin người dùng
    public function updateUser($user_id, $username, $email, $password) {
        $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $user_id]);
    }

    // Xóa người dùng
    public function deleteUser($user_id) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id]);
    }

    // Lấy tất cả đơn hàng
    public function getAllOrders() {
        $sql = "SELECT * FROM orders";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($order_id, $status) {
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $order_id]);
    }

    // Xóa đơn hàng
    public function deleteOrder($order_id) {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$order_id]);
    }

    // Lấy danh sách đơn hàng theo trạng thái
    public function getOrdersByStatus($status) {
        $sql = "SELECT * FROM orders WHERE status = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
