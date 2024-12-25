<?php
require_once '../database/connect.php';
require_once '../models/adminmodels.php';
class AdminController {
    private $db;

    public function __construct() {
        $this->db = connectdb();
    }
    public function addProduct($name, $price, $stock, $image) {
        if (!empty($image)) {
            $target_dir = "../assets/img/";
            $target_file = $target_dir . basename($image["name"]);
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $stmt = $this->db->prepare("INSERT INTO products (name, price, stock, image) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $price, $stock, $image["name"]]);
            }
        }
    }

    // Sửa sản phẩm
    public function editProduct($product_id, $name, $price, $stock, $image) {
        if (!empty($image)) {
            $target_dir = "../assets/img/";
            $target_file = $target_dir . basename($image["name"]);
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $stmt = $this->db->prepare("UPDATE products SET name = ?, price = ?, stock = ?, image = ? WHERE product_id = ?");
                $stmt->execute([$name, $price, $stock, $image["name"], $product_id]);
                return;
            }
        }
        $stmt = $this->db->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE product_id = ?");
        $stmt->execute([$name, $price, $stock, $product_id]);
    }

    // Xóa sản phẩm
    public function deleteProduct($product_id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
    }

    public function getUsers() {
        $stmt = $this->db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy người dùng theo ID
    public function getUserById($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật thông tin người dùng
    public function updateUser($user_id, $username, $email, $password) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE user_id = ?");
        $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $user_id]);
    }

    // Xóa người dùng
    public function deleteUser($user_id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
    }

    // ======================= Đơn hàng =======================
    // Lấy đơn hàng theo trạng thái
    public function getOrdersByStatus($status) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE status = ?");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả đơn hàng
    public function getAllOrders() {
        $stmt = $this->db->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($order_id, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->execute([$status, $order_id]);
    }

    // Xóa đơn hàng
    public function deleteOrder($order_id) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);
    }
}
?>
