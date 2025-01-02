<?php
require_once './models/ProductModels.php';
require_once './models/ShoppingCartModels.php';
require_once './core/Controllers.php';

class HomeController extends Controllers{
    private $db;
    
    public function __construct($db)
    {
        if (!$db) {
            die('Database connection is not established');
        }
        $this->db = $db;
    }


    public function home() {
        // $input = json_decode(file_get_contents('php://input'), true);

        $data = ['default'];
        $quantity = 1;
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        $limit = 24;
        $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;
        $userId = $_SESSION['user_id'] ?? null;
        $productModel = new ProductModel($this->db);
        $cartModel = new CartModel($this->db);

        $allProduct = $productModel->getBestSellers();
        $products = $productModel->getBestSellersByCategory($categoryId, $limit);
        $totalProducts = $productModel->getAllBestSellersCount($categoryId);   
        $favorite = $productId ? $productModel->favorite($userId, $productId) : null;
        $cart = $cartModel -> addToCart($userId, $productId, $quantity);
    
        $this->view('homeview', [
            'cart' => $cart,
            'allProduct' => $allProduct,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categoryId' => $categoryId,
            'limit' => $limit,
        // ] , $data);
        // $this -> view('favorite',[
            'userId' => $userId,
            'productId' => $productId,
        ],$data);
    }
    
    public function favorite() {
        header('Content-Type: application/json');
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $userId = $input['user_id'] ?? null;
            $productId = $input['product_id'] ?? null;
            if (!$userId || !$productId) {
                echo json_encode(['success' => false, 'message' => 'Missing user or product ID.']);
                return;
            }

            $favoriteModel = new FavoriteModel($this->db);
            $result = $favoriteModel->favorite($userId, $productId);

            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    public function aboutus(){
        $this->view('aboutusview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]); 
    }


    public function addToCart($data)
        {
            // Kiểm tra dữ liệu từ JSON
            if (isset($data['product_id']) && isset($data['quantity']) && isset($data['user_id'])) {
                $productId = $data['product_id'];
                $quantity = $data['quantity'];
                $userId = $data['user_id'];
        
                // Kiểm tra xem người dùng đã có giỏ hàng chưa
                $stmt = $this->db->prepare("SELECT * FROM shoppingcart WHERE user_id = ?");
                $stmt->execute([$userId]);
                $cart = $stmt->fetch();
        
                if (!$cart) {
                    // Nếu người dùng chưa có giỏ hàng, tạo giỏ hàng mới
                    $stmt = $this->db->prepare("INSERT INTO shoppingcart (user_id, cart_id) VALUES (?,?)");
                    $stmt->execute([$userId]);
                    $cartId = $this->db->lastInsertId(); // Lấy cart_id của giỏ hàng mới tạo
                } else {
                    // Nếu người dùng đã có giỏ hàng, lấy cart_id
                    $cartId = $cart['cart_id'];
                }
        
                // Kiểm tra sản phẩm có tồn tại trong cơ sở dữ liệu
                $stmt = $this->db->prepare("SELECT * FROM product WHERE product_id = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch();
        
                if ($product) {
                    // Kiểm tra số lượng sản phẩm còn trong kho
                    if ($product['stock'] >= $quantity) {
                        // Thêm sản phẩm vào bảng cartitem
                        $stmt = $this->db->prepare("INSERT INTO cartitem (cart_id, product_id, quantity) VALUES (?, ?, ?)");
                        $stmt->execute([$cartId, $productId, $quantity]);
        
                        echo json_encode(["success" => true, "message" => "Sản phẩm đã được thêm vào giỏ hàng"]);
                    } else {
                        echo json_encode(["success" => false, "message" => "Không đủ số lượng"]);
                    }
                } else {
                    echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại"]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Thiếu dữ liệu"]);
            }
        }
        
}
?> 