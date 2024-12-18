<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/database/connect.php";

class CartModel {
    private $db;

    public function __construct() {
        $this->db = connectdb();
    }

    // Lấy sản phẩm trong giỏ hàng của người dùng
    public function getCartItems($userId) {
        $sql = "SELECT ci.cart_id, ci.product_id, p.name, p.price, ci.quantity, p.image_url 
                FROM shoppingcart sc
                JOIN cartitem ci ON sc.cart_id = ci.cart_id
                JOIN product p ON p.product_id = ci.product_id
                WHERE sc.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tính tổng tiền của giỏ hàng
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
        return $result['total'] ?? 0;
    }

    // Cập nhật số lượng sản phẩm
    public function updateCartItem($userId, $productId, $quantity) {
        $sql = "UPDATE cartitem ci
                JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
                SET ci.quantity = :quantity
                WHERE sc.user_id = :user_id AND ci.product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
