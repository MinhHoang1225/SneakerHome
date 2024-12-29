<?php
// session_start();
// session_start();

// require_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/models/ShoppingCartModels.php";
// require_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/database/connect.php"; // Kết nối cơ sở dữ liệu

// // Kiểm tra đăng nhập
// $userId = $_SESSION['user_id'] ?? null;
// if (!$userId) {
//     echo "Please log in to view your cart.";
//     exit;
// }

// // Kết nối cơ sở dữ liệu
// $db = connectdb(); // Lấy kết nối từ hàm connectdb

// // Khởi tạo đối tượng CartModel với kết nối cơ sở dữ liệu
// $cartModel = new CartModel($db); // Truyền đối số $db vào đây

// // Xử lý cập nhật số lượng sản phẩm từ AJAX
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
//     $productId = (int)$_POST['product_id'];
//     $quantity = (int)$_POST['quantity'];
//     if ($quantity > 0) {
//         $cartModel->updateCartItem($userId, $productId, $quantity);
//         $newTotal = $cartModel->calculateCartTotal($userId);
//         echo json_encode(['status' => 'success', 'total' => $newTotal]);
//         exit;
//     }
// }

// // Lấy thông tin giỏ hàng và tổng giá trị giỏ hàng
// $cartItems = $cartModel->getCartItems($userId);
// $cartTotal = $cartModel->calculateCartTotal($userId);

// // Bao gồm view hiển thị giỏ hàng
// include $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/views/shoppingcartview.php";
require './core/Controllers.php';
class ShoppingCartController extends Controllers{
    private $db;

    // Constructor to initialize ProductModel
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Method to display products
    public function shoppingCart(){
        $this->view('shoppingcartview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }
}

?>
