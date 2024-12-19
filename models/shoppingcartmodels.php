    <?php
    // // header('Content-Type: application/json');
    require_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/database/connect.php";
    // $userId = $_SESSION['user_id'] ?? null;
    session_start(); // Make sure to start the session if it's not already started

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = $data['action'] ?? '';
    $cartModel = new CartModel();

    // If the action is 'add_to_cart', handle adding to the cart
    if ($action === 'add_to_cart') {
        // Get the product details from the POST data
        $productId = intval($data['product_id']);
        $quantity = intval($data['quantity']);

        // Retrieve the user_id from the session
        $userId = $_SESSION['user_id'] ?? null;

        // Check if user is logged in
        if ($userId === null) {
            // If user is not logged in, return an error response
            echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
            exit;
        }

        // Call the method to add the product to the cart
        $success = $cartModel->addToCart($userId, $productId, $quantity);
        echo json_encode(['success' => $success]);
        exit;
    }
}
    
    class CartModel {
        private $db;

        public function __construct() {
            $this->db = connectdb();
        }

        // Lấy sản phẩm trong giỏ hàng của người dùng
        public function getCartItems($userId) {
            $sql = "SELECT ci.cart_id, ci.product_id, p.name, p.price, ci.quantity, p.image_url 
                    FROM shoppingcart sc
                    JOIN cartitem ci ON sc.cart_id = ci.cart_id
                    JOIN product p ON p.product_id = ci.product_id
                    WHERE sc.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Tính tổng tiền của giỏ hàng
        public function calculateCartTotal($userId) {
            $sql = "SELECT SUM(p.price * ci.quantity) AS total
                    FROM cartitem ci
                    JOIN product p ON ci.product_id = p.product_id
                    JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
                    WHERE sc.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        }

        // Cập nhật số lượng sản phẩm
        public function updateCartItem($userId, $productId, $quantity) {
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

        //Thêm sản phẩm vào giỏ hàng
        public function addToCart($userId, $productId, $quantity) {
            try {
                // Check if the user already has a cart
                $checkCartSql = "SELECT cart_id FROM shoppingcart WHERE user_id = :user_id";
                $checkCartStmt = $this->db->prepare($checkCartSql);
                $checkCartStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $checkCartStmt->execute();
                $cartId = $checkCartStmt->fetchColumn();
        
                if (!$cartId) {
                    // If no cart exists, create one
                    $createCartSql = "INSERT INTO shoppingcart (user_id) VALUES (:user_id)";
                    $createCartStmt = $this->db->prepare($createCartSql);
                    $createCartStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $createCartStmt->execute();
                    $cartId = $this->db->lastInsertId(); // Retrieve the cart_id just created
                }
        
                // Add or update the product in the cart
                $sql = "INSERT INTO cartitem (cart_id, product_id, quantity) 
                        VALUES (:cart_id, :product_id, :quantity)
                        ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                
                // Return success or failure
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false; // Failed to add or update cart
                }
            } catch (Exception $e) {
                // Log the exception message (for debugging)
                error_log('Error adding to cart: ' . $e->getMessage());
                return false; // In case of exception
            }
        }
    }

?>
