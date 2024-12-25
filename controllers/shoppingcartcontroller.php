<?php
// session_start();
require_once  $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/models/shoppingcartmodels.php";

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo "Please log in to view your cart.";
    exit;
}

$cartModel = new CartModel();

// Xử lý cập nhật số lượng sản phẩm từ AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $productId = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    if ($quantity > 0) {
        $cartModel->updateCartItem($userId, $productId, $quantity);
        $newTotal = $cartModel->calculateCartTotal($userId);
        echo json_encode(['status' => 'success', 'total' => $newTotal]);
        exit;
    }
}

$cartItems = $cartModel->getCartItems($userId);
$cartTotal = $cartModel->calculateCartTotal($userId);

include $_SERVER['DOCUMENT_ROOT'] ."/SneakerHome/views/shoppingcartview.php";
?>
