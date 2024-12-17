<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/database/connect.php"; // Kết nối cơ sở dữ liệu

class CartModel {
    private $db;

    public function __construct() {
        $this->db = connectdb(); // Kết nối đến cơ sở dữ liệu
    }

    // Lấy các sản phẩm trong giỏ hàng của người dùng
    public function getCartItems($userId) {
        // Truy vấn lấy tất cả sản phẩm trong giỏ hàng của người dùng
        $sql = "SELECT ci.cart_id, p.name, p.price, ci.quantity, p.image_url 
                FROM shoppingcart sc
                JOIN cartitem ci ON sc.cart_id = ci.cart_id
                JOIN product p ON p.product_id = ci.product_id
                WHERE sc.user_id = :user_id"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về các sản phẩm trong giỏ hàng
    }

    // Tính tổng tiền giỏ hàng
    public function calculateCartTotal($userId) {
        $sql = "SELECT SUM(p.price * ci.quantity) AS total
                FROM cartitem ci
                JOIN product p ON ci.product_id = p.product_id
                JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
                WHERE sc.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total']; // Trả về tổng tiền của giỏ hàng
    }
}

?>
