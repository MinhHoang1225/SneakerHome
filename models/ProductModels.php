<?php 
require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/database/connect.php';
 
class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

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

    public function calculateCartTotal($userId) {
        $sql = "SELECT SUM(p.price * ci.quantity) AS total
                FROM shoppingcart sc
                JOIN cartitem ci ON sc.cart_id = ci.cart_id
                JOIN product p ON p.product_id = ci.product_id
                WHERE sc.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

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

    public function removeFromCart($userId, $productId) {
        try {
            $sqlCartId = "SELECT cart_id FROM shoppingcart WHERE user_id = :user_id";
            $stmtCartId = $this->db->prepare($sqlCartId);
            $stmtCartId->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmtCartId->execute();
            $cartId = $stmtCartId->fetchColumn();

            if (!$cartId) {
                error_log("Cart ID not found for user_id: $userId");
                return false;
            }

            $sqlDelete = "DELETE FROM cartitem WHERE cart_id = :cart_id AND product_id = :product_id";
            $stmtDelete = $this->db->prepare($sqlDelete);
            $stmtDelete->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            $stmtDelete->bindParam(':product_id', $productId, PDO::PARAM_INT);

            return $stmtDelete->execute();
        } catch (Exception $e) {
            error_log("Error removing product from cart: " . $e->getMessage());
            return false;
        }
    }

    public function addToCart($userId, $productId, $quantity) {
        try {
            $checkCartSql = "SELECT cart_id FROM shoppingcart WHERE user_id = :user_id";
            $checkCartStmt = $this->db->prepare($checkCartSql);
            $checkCartStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $checkCartStmt->execute();
            $cartId = $checkCartStmt->fetchColumn();

            if (!$cartId) {
                $createCartSql = "INSERT INTO shoppingcart (user_id) VALUES (:user_id)";
                $createCartStmt = $this->db->prepare($createCartSql);
                $createCartStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $createCartStmt->execute();
                $cartId = $this->db->lastInsertId();
            }

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

function getProductDetails($product_id) {
    $sql = "SELECT product_id,category_id, name, price, old_price, discount, image_url, description, stock, color
            FROM product 
            WHERE product_id = :product_id";

    $conn = connectdb(); // Lấy kết nối từ file database
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 sản phẩm
}

function getRelatedProducts($product_id, $category_id) {
    $conn = connectdb();
    $sql = "SELECT product_id, name, price, old_price, discount, image_url
            FROM product 
            WHERE category_id = :category_id AND product_id != :product_id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);


    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$db = connectdb();
    class ProductModel {
        private $db;
        
        public function __construct($db) {
            $this->db = $db;
        }
    

    public function getBestSellers($limit = 8) {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url FROM product WHERE is_best_seller = 1 LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        // Kiểm tra nếu có lỗi trong truy vấn
        if ($stmt->errorCode() !== '00000') {
            die("Lỗi truy vấn SQL: " . implode(", ", $stmt->errorInfo()));
        }
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBestSellers() {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url FROM product WHERE is_best_seller = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    
        // Kiểm tra nếu có lỗi trong truy vấn
        if ($stmt->errorCode() !== '00000') {
            die("Lỗi truy vấn SQL: " . implode(", ", $stmt->errorInfo()));
        }
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllBestSellersCount($categoryId = null) {
        if ($categoryId === null) {
            $sql = "SELECT COUNT(*) FROM product WHERE is_best_seller = 1";
        } else {
            $sql = "SELECT COUNT(*) FROM product WHERE is_best_seller = 1 AND category_id = :category_id";
        }
    
        $stmt = $this->db->prepare($sql);
        if ($categoryId !== null) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }

    public function getBestSellersByCategory($categoryId, $limit = 8) {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url 
                FROM product 
                WHERE is_best_seller = 1 AND category_id = :category_id 
                LIMIT :limit";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    }
    
   // Lấy danh sách sản phẩm theo category_id
function getProductsByCategory($category_id = null) {
    $conn = connectdb();
    if ($category_id) {
        $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("SELECT * FROM product");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


class Product {
    private $db;

    public function __construct() {
        $this->db = connectdb();
    }

    public function searchByName($keyword) {
        $query = "SELECT * FROM Product WHERE name LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
class FavoriteModel {
    private $db;

    public function __construct($db) {
        $this->db = $db; // Inject the database connection into the constructor
    }

    public function toggleFavorite($userId, $productId) {
        try {
            // Check if the product is already a favorite
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorite WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            $exists = $stmt->fetchColumn();
    
            // Prepare the response array
            $response = ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật danh sách yêu thích.'];
    
            if ($exists) {
                // If exists, remove it from favorites
                $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
                $result = $stmt->execute([$userId, $productId]);
    
                if ($result) {
                    $response['success'] = true;
                    $response['is_favorited'] = false; // Product was removed from favorites
                    $response['message'] = 'Sản phẩm đã bị xóa khỏi danh sách yêu thích'; // Correct message for removal
                }
            } else {
                // If not, add it to favorites
                $stmt = $this->db->prepare("INSERT INTO favorite (user_id, product_id) VALUES (?, ?)");
                $result = $stmt->execute([$userId, $productId]);
    
                if ($result) {
                    $response['success'] = true;
                    $response['is_favorited'] = true; // Product was added to favorites
                    $response['message'] = 'Sản phẩm đã được thêm vào danh sách yêu thích'; // Correct message for addition
                }
            }
    
            return $response; // Return the response array
    
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            return ['success' => false, 'message' => 'Đã xảy ra lỗi khi xử lý yêu cầu.'];
        }
    }
    
    

    public function getFavorites($userId) {
        try {
            $stmt = $this->db->prepare("SELECT p.* FROM product p JOIN favorite f ON p.product_id = f.product_id WHERE f.user_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            return [];
        }
    }

    // PHP method to handle removing a favorite from the database
    public function removeFavorite($userId, $productId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$userId, $productId]);
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            return false;
        }
    }
}

?>