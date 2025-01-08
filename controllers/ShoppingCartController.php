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
    public function shoppingCart(){
        $this->view('ShoppingCartView','shoppingcartview', [
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
    
} 

?>  