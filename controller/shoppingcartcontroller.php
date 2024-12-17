<?php
session_start();

// Kết nối với cơ sở dữ liệu và yêu cầu CartModel
require_once '../database/connect.php';
require_once '../models/shoppingcartmodels.php'; // Đảm bảo đường dẫn chính xác

// session_start();
$userId = $_SESSION['user_id'] ?? null;

if ($userId) {
    $cartModel = new CartModel();
    $cartItems = $cartModel->getCartItems($userId);
    $cartTotal = $cartModel->calculateCartTotal($userId);

    include '../views/shoppingcartview.php';
} else {
    echo "Please log in to view your cart.";
    exit;
}
?>
