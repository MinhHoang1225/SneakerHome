<?php
public function addToCart($user_id, $productId) {
    try {
        // Kiểm tra giỏ hàng có tồn tại không
        $query_cart_check = "SELECT cart_id FROM shoppingcart WHERE user_id = :user_id";
        $stmt_cart_check = $this->db->prepare($query_cart_check);
        $stmt_cart_check->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt_cart_check->execute();

        if ($stmt_cart_check->rowCount() > 0) {
            // Giỏ hàng đã tồn tại, lấy cart_id
            $cart = $stmt_cart_check->fetch(PDO::FETCH_ASSOC);
            $cart_id = $cart['cart_id'];
        } else {
            // Tạo giỏ hàng mới
            $query_cart_create = "INSERT INTO shoppingcart (user_id) VALUES (:user_id)";
            $stmt_cart_create = $this->db->prepare($query_cart_create);
            $stmt_cart_create->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt_cart_create->execute();
            $cart_id = $this->db->lastInsertId();
        }

        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $query_check_item = "SELECT quantity FROM cartitem WHERE cart_id = :cart_id AND product_id = :product_id";
        $stmt_check_item = $this->db->prepare($query_check_item);
        $stmt_check_item->bindParam(":cart_id", $cart_id, PDO::PARAM_INT);
        $stmt_check_item->bindParam(":product_id", $productId, PDO::PARAM_INT);
        $stmt_check_item->execute();

        if ($stmt_check_item->rowCount() > 0) {
            // Nếu sản phẩm đã có, tăng số lượng
            $row = $stmt_check_item->fetch(PDO::FETCH_ASSOC);
            $quantity = $row['quantity'] + 1;

            $query_update_item = "UPDATE cartitem SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id";
            $stmt_update_item = $this->db->prepare($query_update_item);
            $stmt_update_item->bindParam(":quantity", $quantity, PDO::PARAM_INT);
            $stmt_update_item->bindParam(":cart_id", $cart_id, PDO::PARAM_INT);
            $stmt_update_item->bindParam(":product_id", $productId, PDO::PARAM_INT);
            $stmt_update_item->execute();
        } else {
            // Nếu chưa có, thêm mới sản phẩm vào giỏ
            $query_insert_item = "INSERT INTO cartitem (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)";
            $stmt_insert_item = $this->db->prepare($query_insert_item);
            $quantity = 1; // Mặc định thêm mới số lượng là 1
            $stmt_insert_item->bindParam(":cart_id", $cart_id, PDO::PARAM_INT);
            $stmt_insert_item->bindParam(":product_id", $productId, PDO::PARAM_INT);
            $stmt_insert_item->bindParam(":quantity", $quantity, PDO::PARAM_INT);
            $stmt_insert_item->execute();
        }

        return ['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng!'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
?>
<?php
try {
    // Lấy dữ liệu từ body request
    $input = json_decode(file_get_contents('php://input'), true);

    // Kiểm tra dữ liệu hợp lệ
    if (!isset($input['product_id']) || empty($input['product_id'])) {
        throw new Exception('ID sản phẩm không hợp lệ!');
    }

    $productId = $input['product_id'];
    $user_id = $_SESSION['user_id'] ?? null; // Giả sử user_id được lưu trong session

    if (!$user_id) {
        throw new Exception('Người dùng chưa đăng nhập!');
    }

    // Thêm sản phẩm vào giỏ hàng
    $cartResponse = $this->addToCart($user_id, $productId);

    // Trả về phản hồi
    echo json_encode($cartResponse);
} catch (Exception $e) {
    // Trả về lỗi
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
?>
