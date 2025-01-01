<?php

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
require './models/ShoppingCartModels.php';
class ShoppingCartController extends Controllers{
    private $db;

    // Constructor to initialize ProductModel
    public function __construct($db)
{
    $this->db = $db;  
    $this->cartModel = new CartModel($this->db);
}

    
    // public function detailProduct() {
    //     try {
    //         // Lấy product_id từ GET
    //         $productId = $_GET['product_id'] ?? null;
    //         if (!$productId) {
    //             throw new Exception('Sản phẩm không tồn tại.');
    //         }

    //         // Tạo instance của ProductModel để lấy thông tin sản phẩm
    //         $productModel = new ProductModel($this->db);
    //         $product = $productModel->getProductById($productId);
    //         $relatedProducts = $productModel->getRelatedProducts($productId);

    //         if (!$product) {
    //             throw new Exception('Không tìm thấy sản phẩm.');
    //         }

    //         // Gửi thông tin sản phẩm và sản phẩm liên quan vào view
    //         $this->view('detailproductview', [
    //             'product' => $product,
    //             'related_products' => $relatedProducts
    //         ]);

    //     } catch (Exception $e) {
    //         // Xử lý lỗi, có thể hiển thị thông báo lỗi
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }
    // public function addToCart($product_id, $quantity = 1) {  // Set default quantity to 1

    //     try {
    //         if (empty($product_id)) {
    //             echo json_encode(["success" => false, "message" => "Thiếu thông tin sản phẩm"]);
    //             return;
    //         }

    //         // Use the provided quantity, or default to 1 if it's not provided
    //         $quantity = $quantity > 0 ? $quantity : 1;

    //         // Use the CartModel to add the product to the cart
    //         $result = $this->cartModel->addProductToCart($product_id, $quantity);

    //         if ($result) {
    //             echo json_encode(["success" => true, "message" => "Thêm vào giỏ hàng thành công"]);
    //         } else {
    //             echo json_encode(["success" => false, "message" => "Không thể thêm vào giỏ hàng"]);
    //         }
    //     } catch (Exception $e) {
    //         echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi: " . $e->getMessage()]);
    //     }
    // }

    // public function removeFromCart($product_id) {
    //     try {
    //         if (empty($product_id)) {
    //             echo json_encode(["success" => false, "message" => "Thiếu thông tin sản phẩm"]);
    //             return;
    //         }

    //         $result = $this->model->removeProductFromCart($product_id);

    //         if ($result) {
    //             echo json_encode(["success" => true, "message" => "Xóa sản phẩm khỏi giỏ hàng thành công"]);
    //         } else {
    //             echo json_encode(["success" => false, "message" => "Không thể xóa sản phẩm khỏi giỏ hàng"]);
    //         }
    //     } catch (Exception $e) {
    //         echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi: " . $e->getMessage()]);
    //     }
    // }

    // public function getCartItems() {
    //     try {
    //         $cartItems = $this->model->getCartItems();

    //         echo json_encode(["success" => true, "data" => $cartItems]);
    //     } catch (Exception $e) {
    //         echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi: " . $e->getMessage()]);
    //     }
    // }
    
        // Thêm sản phẩm vào giỏ hàng
        public function addToCart($data)
        {
            // Kiểm tra dữ liệu từ JSON
            if (isset($data['product_id']) && isset($data['quantity']) && ($data[$_SESSION['userId']])) {
                $productId = $data['product_id'];
                $quantity = $data['quantity'];
                $userId = $data[$_SESSION['userId']];
        
                // Kiểm tra xem người dùng đã có giỏ hàng chưa
                $stmt = $this->db->prepare("SELECT * FROM shoppingcart WHERE user_id = :user_id");
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
        
        
        
        
        
    
        // Lấy các sản phẩm trong giỏ hàng
        public function getCartItems() {
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập']);
                return;
            }
    
            
            $cartItems = $this->cartModel->getCartItems($userId);
            $cartTotal = $this->cartModel->calculateCartTotal($userId);
            echo json_encode(['success' => true, 'data' => $cartItems, 'total' => $cartTotal]);
        }
    
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        public function updateCartItem() {
            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            $userId = $_SESSION['user_id'] ?? null;
    
            if (!$userId || !$productId || $quantity <= 0) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                return;
            }
    
            $result = $this->cartModel->updateCartItem($userId, $productId, $quantity);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được cập nhật']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể cập nhật sản phẩm']);
            }
        }
    
        // Xóa sản phẩm khỏi giỏ hàng
        public function removeFromCart() {
            $productId = $_POST['product_id'] ?? null;
            $userId = $_SESSION['user_id'] ?? null;
    
            if (!$userId || !$productId) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                return;
            }
    
            $result = $this->cartModel->removeFromCart($userId, $productId);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm']);
            }    
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
    
    


?>
