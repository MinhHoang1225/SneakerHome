<?php
    // // header('Content-Type: application/json');
    require_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/database/connect.php";
    // $userId = $_SESSION['user_id'] ?? null;
    // session_start(); // Make sure to start the session if it's not already started
    
    class CartModel {
        private $db;

        public function __construct() {
            $this->db = connectdb();
        }

    // Lấy sản phẩm trong giỏ hàng của người dùng
    public function getCartItems($userId) {
        $query = "SELECT * FROM cart WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



        // Tính tổng tiền của giỏ hàng
        public function calculateCartTotal($userId)
        {
            $sql = "SELECT SUM(ci.quantity * p.price) AS total
                    FROM cartitem ci
                    JOIN product p ON ci.product_id = p.product_id
                    JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
                    WHERE sc.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        
        public function checkStock($productId)
        {
            $sql = "SELECT stock FROM product WHERE product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        
        public function getProductPrice($productId)
        {
            $sql = "SELECT price FROM product WHERE product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        
        // Update cart item quantity
        public function updateCartItem($userId, $productId, $quantity)
            {
                // Kiểm tra xem có đủ hàng tồn kho không
                $availableStock = $this->checkStock($productId);
                if ($quantity > $availableStock) {
                    return false; // Không đủ hàng tồn kho
                }

                $sql = "UPDATE cartitem ci
                        JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
                        SET ci.quantity = :quantity
                        WHERE sc.user_id = :user_id AND ci.product_id = :product_id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                return $stmt->execute();
}


        public function removeFromCart($userId, $productId) {
            try {
                // Truy vấn lấy cart_id từ user_id
                $sqlCartId = "SELECT cart_id FROM shoppingcart WHERE user_id = :user_id";
                $stmtCartId = $this->db->prepare($sqlCartId);
                $stmtCartId->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmtCartId->execute();
                $cartId = $stmtCartId->fetchColumn();
        
                if (!$cartId) {
                    error_log("Cart ID not found for user_id: $userId");
                    return false;
                }
        
                // Xóa sản phẩm khỏi cartitem dựa trên cart_id và product_id
                $sqlDelete = "DELETE FROM cartitem WHERE cart_id = :cart_id AND product_id = :product_id";
                $stmtDelete = $this->db->prepare($sqlDelete);
                $stmtDelete->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
                $stmtDelete->bindParam(':product_id', $productId, PDO::PARAM_INT);
        
                if ($stmtDelete->execute()) {
                    error_log("Deleted product_id: $productId from cart_id: $cartId");
                    return true;
                } else {
                    error_log("Failed to delete product_id: $productId from cart_id: $cartId");
                    return false;
                }
            } catch (Exception $e) {
                error_log("Error removing product from cart: " . $e->getMessage());
                return false;
            }
        }
        
        
                //Thêm sản phẩm vào giỏ hàng
                public function addToCart($userId, $productId, $quantity) {
                    try {
                        // Kiểm tra cart tồn tại
                        $checkCartSql = "SELECT cart_id FROM shoppingcart WHERE user_id = :user_id";
                        $checkCartStmt = $this->db->prepare($checkCartSql);
                        $checkCartStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                        $checkCartStmt->execute();
                        $cartId = $checkCartStmt->fetchColumn();
            
                        if (!$cartId) {
                            // Tạo cart mới nếu chưa tồn tại
                            $createCartSql = "INSERT INTO shoppingcart (user_id) VALUES (:user_id)";
                            $createCartStmt = $this->db->prepare($createCartSql);
                            $createCartStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                            $createCartStmt->execute();
                            $cartId = $this->db->lastInsertId();
                        }
            
                        // Thêm hoặc cập nhật sản phẩm trong cart
                        $sql = "INSERT INTO cartitem (cart_id, product_id, quantity) 
                                VALUES (:cart_id, :product_id, :quantity)
                                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
                        $stmt = $this->db->prepare($sql);
                        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
                        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            
                        return $stmt->execute();
                    } catch (Exception $e) {
                        error_log('Error adding to cart: ' . $e->getMessage());
                        return false;
                    }
                }
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json'); // Đảm bảo trả về JSON
                $data = json_decode(file_get_contents("php://input"), true);
                $action = $data['action'] ?? '';
            
                $cartModel = new CartModel();
            
                if ($action === 'add_to_cart') {
                    $productId = intval($data['product_id']);
                    $quantity = intval($data['quantity']);
                    $userId = $_SESSION['user_id'] ?? null;
            
                    if ($userId === null) {
                        echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
                        exit;
                    }
            
                    $success = $cartModel->addToCart($userId, $productId, $quantity);
                    echo json_encode(['success' => $success]);
                    exit;
                }
            }
?>
