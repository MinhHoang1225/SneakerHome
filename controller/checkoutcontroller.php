<?php
// checkoutController.php
// session_start();    
// Include the necessary model files
require_once '../models/shoppingcartmodels.php';
require_once '../database/connect.php'; // File kết nối DB
$db = connectdb();

// Start the session
// session_start();

// Check if the user is logged in
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: login.php");
    exit;
}

// Create a new CartModel object
$cartModel = new CartModel($db);

// Check if the "Buy Now" action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'buy_now' && !empty($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);
    $quantity = intval($_GET['quantity']);

    if ($productId > 0) {
        // Fetch the product details
        $sql = "SELECT p.product_id, p.name, p.price, p.image_url
                FROM product p
                WHERE p.product_id = :product_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate the total price based on quantity
        $cartTotalCheckOut = isset($cartItems[0]['price']) ? $cartItems[0]['price'] * $quantity : 0;
        $cartTotal = isset($cartItems[0]['price']) ? $cartItems[0]['price'] : 0;
    } else {
        $cartItems = [];
        $cartTotal = 0;
        $cartTotalCheckOut = 0;
    }
} else {
    // Fetch all items in the user's cart as default
    $cartItems = $cartModel->getCartItems($userId);
    $cartTotal = $cartModel->calculateCartTotal($userId);
}

// Include the checkout view
include '../views/checkoutView.php';
?>
