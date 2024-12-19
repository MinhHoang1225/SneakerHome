    <?php
    // // header('Content-Type: application/json');

    // try {
    //     // Lấy dữ liệu từ body request
    //     $input = json_decode(file_get_contents('php://input'), true);
    
    //     // Kiểm tra dữ liệu hợp lệ
    //     if (!isset($input['product_id']) || empty($input['product_id'])) {
    //         throw new Exception('ID sản phẩm không hợp lệ!');
    //     }
    
    //     $productId = $input['product_id'];
    
    
    //     $response = [
    //         'success' => true,
    //         'message' => 'Sản phẩm đã được thêm vào giỏ hàng!'
    //     ];
    
    //     echo json_encode($response);
    // } catch (Exception $e) {
    //     // Trả về lỗi
    //     $response = [
    //         'success' => false,
    //         'message' =>'dell dc'
    //     ];
    
    //     echo json_encode($response);}
    require_once $_SERVER['DOCUMENT_ROOT'] . "/SneakerHome/database/connect.php";

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

        public function addToCart($user_id, $productId) {
            
            // Kiểm tra giỏ hàng có tồn tại không
            $query_cart_check = "SELECT cart_id FROM shoppingcart WHERE user_id = :user_id";
            $stmt_cart_check = $this ->db->prepare($query_cart_check);
            $stmt_cart_check->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt_cart_check->execute();
        
            if ($stmt_cart_check->rowCount() > 0) {
                // Giỏ hàng đã tồn tại, lấy cart_id
                $cart = $stmt_cart_check->fetch(PDO::FETCH_ASSOC);
                $cart_id = $cart['cart_id'];
            } else {
                // Tạo giỏ hàng mới
                $query_cart_create = "INSERT INTO shoppingcart (user_id) VALUES (:user_id)";
                $stmt_cart_create = $this ->db->prepare($query_cart_create);
                $stmt_cart_create->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                $stmt_cart_create->execute();
                $cart_id =$this ->db->lastInsertId();
            }
        
            // Kiểm tra sản phẩm đã có trong giỏ chưa
            $query_check_item = "SELECT * FROM cartitem WHERE cart_id = :cart_id AND product_id = :product_id";
            $stmt_check_item = $this ->db->prepare($query_check_item);
            $stmt_check_item->bindParam(":cart_id", $cart_id, PDO::PARAM_INT);
            $stmt_check_item->bindParam(":product_id", $productId, PDO::PARAM_INT);
            $stmt_check_item->execute();
        
            if ($stmt_check_item->rowCount() > 0) {
                // Nếu sản phẩm đã có, tăng số lượng
                $row = $stmt_check_item->fetch(PDO::FETCH_ASSOC);
                $quantity = $row['quantity'] + 1;
        
                $query_update_item = "UPDATE cartitem SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id";
                $stmt_update_item = $this ->db->prepare($query_update_item);
                $stmt_update_item->bindParam(":quantity", $quantity, PDO::PARAM_INT);
                $stmt_update_item->bindParam(":cart_id", $cart_id, PDO::PARAM_INT);
                $stmt_update_item->bindParam(":product_id", $productId, PDO::PARAM_INT);
                $stmt_update_item->execute();
            } else {
                // Nếu chưa có, thêm mới sản phẩm vào giỏ
                $query_insert_item = "INSERT INTO cartitem (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)";
                $stmt_insert_item = $this ->db->prepare($query_insert_item);
                $quantity = 1; // Mặc định thêm mới số lượng là 1
                $stmt_insert_item->bindParam(":cart_id", $cart_id, PDO::PARAM_INT);
                $stmt_insert_item->bindParam(":product_id", $productId, PDO::PARAM_INT);
                $stmt_insert_item->bindParam(":quantity", $quantity, PDO::PARAM_INT);
                $stmt_insert_item->execute();
            }
        
            echo "OKsad";
        }
    }

?>