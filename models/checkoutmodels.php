<?php
// shoppingcartmodels.php

session_start();

class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fetch the items in the cart for a specific user
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

    // Calculate the total price for the items in the cart
    public function calculateCartTotal($userId) {
        $sql = "SELECT SUM(p.price * ci.quantity) AS total
                FROM shoppingcart sc
                JOIN cartitem ci ON sc.cart_id = ci.cart_id
                JOIN product p ON p.product_id = ci.product_id
                WHERE sc.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
?>
