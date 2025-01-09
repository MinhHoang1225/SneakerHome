<?php

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

    public function Cart(){
        if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
    
            $cartModel = new CartModel($this->db);
            $cartTotal = $cartModel -> calculateCartTotal($userId);
            $cart = $cartModel->getCartItems($userId);    
            $this->view('ShoppingCartView','shoppingcartview', [
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

    public function handleRemoveCartItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $productId = $data['product_id'] ?? null;
            $userId = $_SESSION['userId'] ?? null;
    
            if (!$userId || !$productId) {
                echo json_encode(['success' => false, 'error' => 'Invalid request.']);
                exit();
            }
    
            $cartModel = new CartModel($this->db);
            $result = $cartModel->removeFromCart($userId, $productId);
    
            if ($result) {
                $cartTotal = $cartModel->calculateCartTotal($userId);
                echo json_encode(['success' => true, 'cartTotal' => $cartTotal]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to remove product.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
        }
        exit();
    }
    
    
} 

?>  