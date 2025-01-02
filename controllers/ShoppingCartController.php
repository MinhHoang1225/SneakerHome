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
require './models/shoppingcartmodels.php';
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

    public function Cart(){
        if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
    
            $cartModel = new CartModel($this->db);
            $cartTotal = $cartModel -> calculateCartTotal($userId);
            $cart = $cartModel->getCartItems($userId);
    
    
            $this->view('shoppingcartview', [
                'cart' => $cart,  
                'cartTotal' => $cartTotal,
                'error_message' => $_SESSION['error_message'] ?? null,
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        } else {
            header("Location: /SneakerHome/User/login");
            exit();
        }
    }

    // public function cart() {
    //     header('Content-Type: application/json');
    
    //     $userId = $_SESSION['user_id'] ?? null;
    //     $data = json_decode(file_get_contents('php://input'), true);
    
    //     $productId = isset($data['product_id']) ? (int)$data['product_id'] : 0;
    //     $quantity = isset($data['quantity']) ? (int)$data['quantity'] : 0;
    
    //     if (!$userId || $productId <= 0 || $quantity <= 0) {
    //         echo json_encode(['success' => false, 'error' => 'Dữ liệu không hợp lệ.']);
    //         return;
    //     }
    
    //     $cartModel = new CartModel($this->db);
    
    //     // Kiểm tra tồn kho
    //     $stock = $cartModel->checkStock($productId);
    //     if ($quantity > $stock) {
    //         echo json_encode(['success' => false, 'error' => 'Số lượng vượt quá tồn kho.']);
    //         return;
    //     }
    
    //     // Cập nhật số lượng
    //     if ($cartModel->updateCartItem($userId, $productId, $quantity)) {
    //         // Tính lại tổng giá
    //         $cartTotal = $cartModel->calculateCartTotal($userId);
    //         $productTotal = $quantity * $cartModel->getProductPrice($productId);
    //         echo json_encode(['success' => true, 'cartTotal' => $cartTotal, 'productTotal' => $productTotal]);
    //     } else {
    //         echo json_encode(['success' => false, 'error' => 'Cập nhật thất bại.']);
    //     }
    // }
    
    
} 

?>  